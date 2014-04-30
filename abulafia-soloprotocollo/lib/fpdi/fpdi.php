<?php
//
//  FPDI - Version 1.5.1
//
//    Copyright 2004-2014 Setasign - Jan Slabon
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//

require_once('fpdf_tpl.php');

/**
 * Class FPDI
 */
class FPDI extends FPDF_TPL
{
    /**
     * FPDI version
     *
     * @string
     */
    const VERSION = '1.5.1';

    /**
     * Actual filename
     *
     * @var string
     */
    public $currentFilename;

    /**
     * Parser-Objects
     *
     * @var fpdi_pdf_parser[]
     */
    public $parsers = array();
    
    /**
     * Current parser
     *
     * @var fpdi_pdf_parser
     */
    public $currentParser;

    /**
     * The name of the last imported page box
     *
     * @var string
     */
    public $lastUsedPageBox;

    /**
     * Object stack
     *
     * @var array
     */
    protected $_objStack;
    
    /**
     * Done object stack
     *
     * @var array
     */
    protected $_doneObjStack;

    /**
     * Current Object Id.
     *
     * @var integer
     */
    protected $_currentObjId;
    
    /**
     * Cache for imported pages/template ids
     *
     * @var array
     */
    protected $_importedPages = array();
    
    /**
     * Set a source-file.
     *
     * Depending on the PDF version of the used document the PDF version of the resulting document will
     * be adjusted to the higher version.
     *
     * @param string $filename A valid path to the PDF document from which pages should be imported from
     * @return int The number of pages in the document
     */
    public function setSourceFile($filename)
    {
        $_filename = realpath($filename);
        if (false !== $_filename)
            $filename = $_filename;

        $this->currentFilename = $filename;
        
        if (!isset($this->parsers[$filename])) {
            $this->parsers[$filename] = $this->_getPdfParser($filename);
            $this->setPdfVersion(
                max($this->getPdfVersion(), $this->parsers[$filename]->getPdfVersion())
            );
        }

        $this->currentParser =& $this->parsers[$filename];
        
        return $this->parsers[$filename]->getPageCount();
    }
    
    /**
     * Returns a PDF parser object
     *
     * @param string $filename
     * @return fpdi_pdf_parser
     */
    protected function _getPdfParser($filename)
    {
        require_once('fpdi_pdf_parser.php');
    	return new fpdi_pdf_parser($filename);
    }
    
    /**
     * Get the current PDF version.
     *
     * @return string
     */
    public function getPdfVersion()
    {
		return $this->PDFVersion;
	}
    
	/**
     * Set the PDF version.
     *
     * @param string $version
     */
	public function setPdfVersion($version = '1.3')
    {
		$this->PDFVersion = $version;
	}
	
    /**
     * Import a page.
     *
     * The second parameter defines the bounding box that should be used to transform the page into a
     * form XObject.
     *
     * Following values are available: MediaBox, CropBox, BleedBox, TrimBox, ArtBox.
     * If a box is not especially defined its default box will be used:
     *
     * <ul>
     *   <li>CropBox: Default -> MediaBox</li>
     *   <li>BleedBox: Default -> CropBox</li>
     *   <li>TrimBox: Default -> CropBox</li>
     *   <li>ArtBox: Default -> CropBox</li>
     * </ul>
     *
     * It is possible to get the used page box by the {@link getLastUsedPageBox()} method.
     *
     * @param int $pageNo The page number
     * @param string $boxName The boundary box to use when transforming the page into a form XObject
     * @param boolean $groupXObject Define the form XObject as a group XObject to support transparency (if used)
     * @return int An id of the imported page/template to use with e.g. fpdf_tpl::useTemplate()
     * @throws LogicException|InvalidArgumentException
     * @see getLastUsedPageBox()
     */
    public function importPage($pageNo, $boxName = 'CropBox', $groupXObject = true)
    {
        if ($this->_inTpl) {
            throw new LogicException('Please import the desired pages before creating a new template.');
        }
        
        $fn = $this->currentFilename;
        $boxName = '/' . ltrim($boxName, '/');

        // check if page already imported
        $pageKey = $fn . '-' . ((int)$pageNo) . $boxName;
        if (isset($this->_importedPages[$pageKey])) {
            return $this->_importedPages[$pageKey];
        }
        
        $parser = $this->parsers[$fn];
        $parser->setPageNo($pageNo);

        if (!in_array($boxName, $parser->availableBoxes)) {
            throw new InvalidArgumentException(sprintf('Unknown box: %s', $boxName));
        }
            
        $pageBoxes = $parser->getPageBoxes($pageNo, $this->k);
        
        /**
         * MediaBox
         * CropBox: Default -> MediaBox
         * BleedBox: Default -> CropBox
         * TrimBox: Default -> CropBox
         * ArtBox: Default -> CropBox
         */
        if (!isset($pageBoxes[$boxName]) && ($boxName == '/BleedBox' || $boxName == '/TrimBox' || $boxName == '/ArtBox'))
            $boxName = '/CropBox';
        if (!isset($pageBoxes[$boxName]) && $boxName == '/CropBox')
            $boxName = '/MediaBox';
        
        if (!isset($pageBoxes[$boxName]))
            return false;
            
        $this->lastUsedPageBox = $boxName;
        
        $box = $pageBoxes[$boxName];
        
        $this->tpl++;
        $this->_tpls[$this->tpl] = array();
        $tpl =& $this->_tpls[$this->tpl];
        $tpl['parser'] = $parser;
        $tpl['resources'] = $parser->getPageResources();
        $tpl['buffer'] = $parser->getContent();
        $tpl['box'] = $box;
        $tpl['groupXObject'] = $groupXObject;
        if ($groupXObject) {
            $this->setPdfVersion(max($this->getPdfVersion(), 1.4));
        }

        // To build an array that can be used by PDF_TPL::useTemplate()
        $this->_tpls[$this->tpl] = array_merge($this->_tpls[$this->tpl], $box);
        
        // An imported page will start at 0,0 all the time. Translation will be set in _putformxobjects()
        $tpl['x'] = 0;
        $tpl['y'] = 0;
        
        // handle rotated pages
        $rotation = $parser->getPageRotation($pageNo);
        $tpl['_rotationAngle'] = 0;
        if (isset($rotation[1]) && ($angle = $rotation[1] % 360) != 0) {
        	$steps = $angle / 90;
                
            $_w = $tpl['w'];
            $_h = $tpl['h'];
            $tpl['w'] = $steps % 2 == 0 ? $_w : $_h;
            $tpl['h'] = $steps % 2 == 0 ? $_h : $_w;
            
            if ($angle < 0)
            	$angle += 360;
            
        	$tpl['_rotationAngle'] = $angle * -1;
        }
        
        $this->_importedPages[$pageKey] = $this->tpl;
        
        return $this->tpl;
    }
    
    /**
     * Returns the last used page boundary box.
     *
     * @return string The used boundary box: MediaBox, CropBox, BleedBox, TrimBox or ArtBox
     */
    public function getLastUsedPageBox()
    {
        return $this->lastUsedPageBox;
    }

    /**
     * Use a template or imported page in current page or other template.
     *
     * You can use a template in a page or in another template.
     * You can give the used template a new size. All parameters are optional.
     * The width or height is calculated automatically if one is given. If no
     * parameter is given the origin size as defined in beginTemplate() or of
     * the imported page is used.
     *
     * The calculated or used width and height are returned as an array.
     *
     * @param int $tplIdx A valid template-id
     * @param int $x The x-position
     * @param int $y The y-position
     * @param int $w The new width of the template
     * @param int $h The new height of the template
     * @param boolean $adjustPageSize If set to true the current page will be resized to fit the dimensions
     *                                of the template
     *
     * @return array The height and width of the template (array('w' => ..., 'h' => ...))
     * @throws LogicException|InvalidArgumentException
     */
    public function useTemplate($tplIdx, $x = null, $y = null, $w = 0, $h = 0, $adjustPageSize = false)
    {
        if ($adjustPageSize == true && is_null($x) && is_null($y)) {
            $size = $this->getTemplateSize($tplIdx, $w, $h);
            $orientation = $size['w'] > $size['h'] ? 'L' : 'P';
            $size = array($size['w'], $size['h']);
            
            if (is_subclass_of($this, 'TCPDF')) {
            	$this->setPageFormat($size, $orientation);
            } else {
            	$size = $this->_getpagesize($size);
            	
            	if($orientation != $this->CurOrientation ||
                    $size[0] != $this->CurPageSize[0] ||
                    $size[1] != $this->CurPageSize[1]
                ) {
					// New size or orientation
					if ($orientation=='P') {
						$this->w = $size[0];
						$this->h = $size[1];
					} else {
						$this->w = $size[1];
						$this->h = $size[0];
					}
					$this->wPt = $this->w * $this->k;
					$this->hPt = $this->h * $this->k;
					$this->PageBreakTrigger = $this->h - $this->bMargin;
					$this->CurOrientation = $orientation;
					$this->CurPageSize = $size;
					$this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
				}
            } 
        }
        
        $this->_out('q 0 J 1 w 0 j 0 G 0 g'); // reset standard values
        $size = parent::useTemplate($tplIdx, $x, $y, $w, $h);
        $this->_out('Q');
        
        return $size;
    }
    
    /**
     * Copy all imported objects to the resulting document.
     */
    protected function _putimportedobjects()
    {
        foreach($this->parsers AS $filename => $p) {
            $this->currentParser =& $p;
            if (!isset($this->_objStack[$filename]) || !is_array($this->_objStack[$filename])) {
                continue;
            }
            while(($n = key($this->_objStack[$filename])) !== null) {
                $nObj = $this->currentParser->resolveObject($this->_objStack[$filename][$n][1]);

                $this->_newobj($this->_objStack[$filename][$n][0]);

                if ($nObj[0] == pdf_parser::TYPE_STREAM) {
                    $this->_writeValue($nObj);
                } else {
                    $this->_writeValue($nObj[1]);
                }

                $this->_out("\nendobj");
                $this->_objStack[$filename][$n] = null; // free memory
                unset($this->_objStack[$filename][$n]);
                reset($this->_objStack[$filename]);
            }
        }
    }

    /**
     * Writes the form XObjects to the PDF document.
     */
    protected function _putformxobjects()
    {
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
	    reset($this->_tpls);
        foreach($this->_tpls AS $tplIdx => $tpl) {
            $this->_newobj();
    		$currentN = $this->n; // TCPDF/Protection: rem current "n"
    		
    		$this->_tpls[$tplIdx]['n'] = $this->n;
    		$this->_out('<<' . $filter . '/Type /XObject');
            $this->_out('/Subtype /Form');
            $this->_out('/FormType 1');
            
            $this->_out(sprintf('/BBox [%.2F %.2F %.2F %.2F]', 
                (isset($tpl['box']['llx']) ? $tpl['box']['llx'] : $tpl['x']) * $this->k,
                (isset($tpl['box']['lly']) ? $tpl['box']['lly'] : -$tpl['y']) * $this->k,
                (isset($tpl['box']['urx']) ? $tpl['box']['urx'] : $tpl['w'] + $tpl['x']) * $this->k,
                (isset($tpl['box']['ury']) ? $tpl['box']['ury'] : $tpl['h'] - $tpl['y']) * $this->k
            ));
            
            $c = 1;
            $s = 0;
            $tx = 0;
            $ty = 0;
            
            if (isset($tpl['box'])) {
                $tx = -$tpl['box']['llx'];
                $ty = -$tpl['box']['lly']; 
                
                if ($tpl['_rotationAngle'] <> 0) {
                    $angle = $tpl['_rotationAngle'] * M_PI/180;
                    $c = cos($angle);
                    $s = sin($angle);
                    
                    switch($tpl['_rotationAngle']) {
                        case -90:
                           $tx = -$tpl['box']['lly'];
                           $ty = $tpl['box']['urx'];
                           break;
                        case -180:
                            $tx = $tpl['box']['urx'];
                            $ty = $tpl['box']['ury'];
                            break;
                        case -270:
                        	$tx = $tpl['box']['ury'];
                            $ty = -$tpl['box']['llx'];
                            break;
                    }
                }
            } else if ($tpl['x'] != 0 || $tpl['y'] != 0) {
                $tx = -$tpl['x'] * 2;
                $ty = $tpl['y'] * 2;
            }
            
            $tx *= $this->k;
            $ty *= $this->k;
            
            if ($c != 1 || $s != 0 || $tx != 0 || $ty != 0) {
                $this->_out(sprintf('/Matrix [%.5F %.5F %.5F %.5F %.5F %.5F]',
                    $c, $s, -$s, $c, $tx, $ty
                ));
            }
            
            $this->_out('/Resources ');

            if (isset($tpl['resources'])) {
                $this->currentParser = $tpl['parser'];
                $this->_writeValue($tpl['resources']); // "n" will be changed
            } else {

                $this->_out('<</ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
                if (isset($this->_res['tpl'][$tplIdx])) {
                    $res = $this->_res['tpl'][$tplIdx];

                    if (isset($res['fonts']) && count($res['fonts'])) {
                        $this->_out('/Font <<');
                        foreach ($res['fonts'] as $font)
                            $this->_out('/F' . $font['i'] . ' ' . $font['n'] . ' 0 R');
                        $this->_out('>>');
                    }
                    if (isset($res['images']) && count($res['images']) ||
                       isset($res['tpls']) && count($res['tpls']))
                    {
                        $this->_out('/XObject <<');
                        if (isset($res['images'])) {
                            foreach ($res['images'] as $image)
                                $this->_out('/I' . $image['i'] . ' ' . $image['n'] . ' 0 R');
                        }
                        if (isset($res['tpls'])) {
                            foreach ($res['tpls'] as $i => $_tpl)
                                $this->_out($this->tplPrefix . $i . ' ' . $_tpl['n'] . ' 0 R');
                        }
                        $this->_out('>>');
                    }
                    $this->_out('>>');
                }
            }

            if (isset($tpl['groupXObject']) && $tpl['groupXObject']) {
                $this->_out('/Group <</Type/Group/S/Transparency>>');
            }

            $newN = $this->n; // TCPDF: rem new "n"
            $this->n = $currentN; // TCPDF: reset to current "n"

            $buffer = ($this->compress) ? gzcompress($tpl['buffer']) : $tpl['buffer'];

            if (is_subclass_of($this, 'TCPDF')) {
            	$buffer = $this->_getrawstream($buffer);
            	$this->_out('/Length ' . strlen($buffer) . ' >>');
            	$this->_out("stream\n" . $buffer . "\nendstream");
            } else {
	            $this->_out('/Length ' . strlen($buffer) . ' >>');
	    		$this->_putstream($buffer);
            }
    		$this->_out('endobj');
    		$this->n = $newN; // TCPDF: reset to new "n"
        }
        
        $this->_putimportedobjects();
    }

    /**
     * Creates and optionally write the object definition to the document.
     *
     * Rewritten to handle existing own defined objects
     *
     * @param bool $objId
     * @param bool $onlyNewObj
     * @return bool|int
     */
    public function _newobj($objId = false, $onlyNewObj = false)
    {
        if (!$objId) {
            $objId = ++$this->n;
        }

        //Begin a new object
        if (!$onlyNewObj) {
            $this->offsets[$objId] = is_subclass_of($this, 'TCPDF') ? $this->bufferlen : strlen($this->buffer);
            $this->_out($objId . ' 0 obj');
            $this->_currentObjId = $objId; // for later use with encryption
        }
        
        return $objId;
    }

    /**
     * Writes a PDF value to the resulting document.
     *
     * Needed to rebuild the source document
     *
     * @param mixed $value A PDF-Value. Structure of values see cases in this method
     */
    protected function _writeValue(&$value)
    {
        if (is_subclass_of($this, 'TCPDF')) {
            parent::_prepareValue($value);
        }
        
        switch ($value[0]) {

    		case pdf_parser::TYPE_TOKEN:
                $this->_straightOut($value[1] . ' ');
    			break;
		    case pdf_parser::TYPE_NUMERIC:
    		case pdf_parser::TYPE_REAL:
                if (is_float($value[1]) && $value[1] != 0) {
    			    $this->_straightOut(rtrim(rtrim(sprintf('%F', $value[1]), '0'), '.') . ' ');
    			} else {
        			$this->_straightOut($value[1] . ' ');
    			}
    			break;
    			
    		case pdf_parser::TYPE_ARRAY:

    			// An array. Output the proper
    			// structure and move on.

    			$this->_straightOut('[');
                for ($i = 0; $i < count($value[1]); $i++) {
    				$this->_writeValue($value[1][$i]);
    			}

    			$this->_out(']');
    			break;

    		case pdf_parser::TYPE_DICTIONARY:

    			// A dictionary.
    			$this->_straightOut('<<');

    			reset ($value[1]);

    			while (list($k, $v) = each($value[1])) {
    				$this->_straightOut($k . ' ');
    				$this->_writeValue($v);
    			}

    			$this->_straightOut('>>');
    			break;

    		case pdf_parser::TYPE_OBJREF:

    			// An indirect object reference
    			// Fill the object stack if needed
    			$cpfn =& $this->currentParser->filename;
    			if (!isset($this->_doneObjStack[$cpfn][$value[1]])) {
    			    $this->_newobj(false, true);
    			    $this->_objStack[$cpfn][$value[1]] = array($this->n, $value);
                    $this->_doneObjStack[$cpfn][$value[1]] = array($this->n, $value);
                }
                $objId = $this->_doneObjStack[$cpfn][$value[1]][0];

    			$this->_out($objId . ' 0 R');
    			break;

    		case pdf_parser::TYPE_STRING:

    			// A string.
                $this->_straightOut('(' . $value[1] . ')');

    			break;

    		case pdf_parser::TYPE_STREAM:

    			// A stream. First, output the
    			// stream dictionary, then the
    			// stream data itself.
                $this->_writeValue($value[1]);
    			$this->_out('stream');
    			$this->_out($value[2][1]);
    			$this->_straightOut("endstream");
    			break;
    			
            case pdf_parser::TYPE_HEX:
                $this->_straightOut('<' . $value[1] . '>');
                break;

            case pdf_parser::TYPE_BOOLEAN:
    		    $this->_straightOut($value[1] ? 'true ' : 'false ');
    		    break;
            
    		case pdf_parser::TYPE_NULL:
                // The null object.

    			$this->_straightOut('null ');
    			break;
    	}
    }
    
    
    /**
     * Modified _out() method so not each call will add a newline to the output.
     */
    protected function _straightOut($s)
    {
        if (!is_subclass_of($this, 'TCPDF')) {
            if ($this->state == 2) {
        		$this->pages[$this->page] .= $s;
            } else {
        		$this->buffer .= $s;
            }

        } else {
            if ($this->state == 2) {
				if ($this->inxobj) {
					// we are inside an XObject template
					$this->xobjects[$this->xobjid]['outdata'] .= $s;
				} else if ((!$this->InFooter) AND isset($this->footerlen[$this->page]) AND ($this->footerlen[$this->page] > 0)) {
					// puts data before page footer
					$pagebuff = $this->getPageBuffer($this->page);
					$page = substr($pagebuff, 0, -$this->footerlen[$this->page]);
					$footer = substr($pagebuff, -$this->footerlen[$this->page]);
					$this->setPageBuffer($this->page, $page . $s . $footer);
					// update footer position
					$this->footerpos[$this->page] += strlen($s);
				} else {
					// set page data
					$this->setPageBuffer($this->page, $s, true);
				}
			} else if ($this->state > 0) {
				// set general data
				$this->setBuffer($s);
			}
        }
    }

    /**
     * Ends the document
     *
     * Overwritten to close opened parsers
     */
    public function _enddoc()
    {
        parent::_enddoc();
        $this->_closeParsers();
    }
    
    /**
     * Close all files opened by parsers.
     *
     * @return boolean
     */
    protected function _closeParsers()
    {
        if ($this->state > 2) {
          	$this->cleanUp();
            return true;
        }

        return false;
    }
    
    /**
     * Removes cycled references and closes the file handles of the parser objects.
     */
    public function cleanUp()
    {
        while (($parser = array_pop($this->parsers)) !== null) {
            /**
             * @var fpdi_pdf_parser $parser
             */
            $parser->closeFile();
        }
    }
    
   function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.4, $h = 9, $wide = true) {

    //Display code
    $this->SetFont('Arial', '', 10);
    $this->Text($x, $y+$h+4,'');

    if($ext)
    {
        //Extended encoding
        $code = $this->encode_code39_ext($code);
    }
    else
    {
        //Convert to upper case
        $code = strtoupper($code);
        //Check validity
        if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code))
            $this->Error('Invalid barcode value: '.$code);
    }

    //Compute checksum
    if ($cks)
        $code .= $this->checksum_code39($code);

    //Add start and stop characters
    $code = '*'.$code.'*';

    //Conversion tables
    $narrow_encoding = array (
        '0' => '101001101101', '1' => '110100101011', '2' => '101100101011', 
        '3' => '110110010101', '4' => '101001101011', '5' => '110100110101', 
        '6' => '101100110101', '7' => '101001011011', '8' => '110100101101', 
        '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011', 
        'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101', 
        'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101', 
        'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011', 
        'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011', 
        'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011', 
        'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001', 
        'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101', 
        'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101', 
        '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101', 
        '*' => '100101101101', '$' => '100100100101', '/' => '100100101001', 
        '+' => '100101001001', '%' => '101001001001' );

    $wide_encoding = array (
        '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111', 
        '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101', 
        '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101', 
        '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111', 
        'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101', 
        'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101', 
        'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111', 
        'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111', 
        'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111', 
        'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001', 
        'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101', 
        'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101', 
        '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101', 
        '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001', 
        '+' => '100010100010001', '%' => '101000100010001');

    $encoding = $wide ? $wide_encoding : $narrow_encoding;

    //Inter-character spacing
    $gap = ($w > 0.29) ? '00' : '0';

    //Convert to bars
    $encode = '';
    for ($i = 0; $i< strlen($code); $i++)
        $encode .= $encoding[$code{$i}].$gap;

    //Draw bars
    $this->draw_code39($encode, $x, $y, $w, $h);
}

function checksum_code39($code) {

    //Compute the modulo 43 checksum

    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
                            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
                            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 
                            'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
    $sum = 0;
    for ($i=0 ; $i<strlen($code); $i++) {
        $a = array_keys($chars, $code{$i});
        $sum += $a[0];
    }
    $r = $sum % 43;
    return $chars[$r];
}

function encode_code39_ext($code) {

    //Encode characters in extended mode

    $encode = array(
        chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C', 
        chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G', 
        chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '£K', 
        chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O', 
        chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S', 
        chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W', 
        chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A', 
        chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E', 
        chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C', 
        chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G', 
        chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K', 
        chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O', 
        chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3', 
        chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7', 
        chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F', 
        chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J', 
        chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C', 
        chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G', 
        chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K', 
        chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O', 
        chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S', 
        chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W', 
        chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K', 
        chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O', 
        chr(96) => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C', 
        chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G', 
        chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K', 
        chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O', 
        chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S', 
        chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W', 
        chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P', 
        chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

    $code_ext = '';
    for ($i = 0 ; $i<strlen($code); $i++) {
        if (ord($code{$i}) > 127)
            $this->Error('Invalid character: '.$code{$i});
        $code_ext .= $encode[$code{$i}];
    }
    return $code_ext;
}

function draw_code39($code, $x, $y, $w, $h){

    //Draw bars

    for($i=0; $i<strlen($code); $i++)
    {
        if($code{$i} == '1')
            $this->Rect($x+$i*$w, $y, $w, $h, 'F');
    }
} 
    
}