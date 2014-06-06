<?php
/*
 * Deals with PowerPoint document level aspects
 */
namespace Aspose\Cloud\Slides;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Storage\Folder;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Document {

    public $fileName = '';

    public function __construct($fileName) {
        //set default values
        $this->fileName = $fileName;
    }

    public function changeSlidePosition($old_position='', $new_position='',$storageName = '', $folder = '') {
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        if ($old_position == '' || $new_position == '')
            throw new Exception('Missing Required Params');


        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/slides?OldPosition=' . $old_position . '&NewPosition=' . $new_position;
        if ($folder != '') {
            $strURI .= 'folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        $json = json_decode($responseStream);


        if ($json->Code == 200)
            return $json->Slides;
        else
            return false;
    }

    public function cloneSlide($slideno='',$position='',$storageName = '', $folder = '') {
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        if ($position == '' )
            throw new Exception('Position not speciefied.');

        if ($slideno == '' )
            throw new Exception('Slide not speciefied.');


        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/slides?SlideToClone=' . $slideno . '&Position=' . $position;
        if ($folder != '') {
            $strURI .= 'folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Slides;
        else
            return false;
    }

    public function addSlide($position='',$storageName = '', $folder = '') {
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        if ($position == '' )
            throw new Exception('Position not speciefied.');


        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/slides?Position=' . $position;
        if ($folder != '') {
            $strURI .= 'folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Slides;
        else
            return false;
    }

    public function splitPresentation($from='',$to='',$destination='',$format='',$storageName = '', $folder = '') {
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/split?';
        if ($folder != '') {
            $strURI .= '&folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }

        if ($from != '') {
            $strURI .= '&from=' . $from;
        }

        if ($to != '') {
            $strURI .= '&to=' . $to;
        }

        if ($destination != '') {
            $strURI .= '&destFolder=' . $destination;
        }

        if ($format != '') {
            $strURI .= '&format=' . $format;
        }

        $strURI = rtrim($strURI,'?');
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

        $json = json_decode($responseStream);



        if ($json->Code == 200) {
            foreach ($json->SplitResult->Slides as $splitPage) {
                $splitFileName = basename($splitPage->Href);

                //build URI to download split slides
                $strURI = Product::$baseProductUri . '/storage/file/' . $splitFileName;
                //sign URI
                $signedURI = Utils::Sign($strURI);
                $responseStream = Utils::processCommand($signedURI, "GET", "", "");
                //save split slides
                $outputFile = AsposeApp::$outPutLocation . $splitFileName;
                Utils::saveFile($responseStream, $outputFile);
            }
        }
        else
            return false;
    }

    public function mergePresentations($presentationsList=array(),$storageName = '', $folder = '') {
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        if (!is_array($presentationsList) || empty($presentationsList) )
            throw new Exception('Presentation list not speciefied');


        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/merge';
        if ($folder != '') {
            $strURI .= '?folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        $signedURI = Utils::sign($strURI);

        $json_data = json_encode($presentationsList);

        $responseStream = Utils::processCommand($signedURI, 'PUT', 'json', $json_data);

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Document;
        else
            return false;
    }
    
    public function createEmptyPresentation($storageName = '', $folder = ''){
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //Build URI to get a list of slides
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName;
        if ($folder != '') {
            $strURI .= '?folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }

        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 201)
            return $json->Document;
        else
            return false;
    }

    /*
     * Finds the slide count of the specified PowerPoint document
     */
    public function getSlideCount($storageName = '', $folder = '') {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //Build URI to get a list of slides
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/slides';
        if ($folder != '') {
            $strURI .= '?folder=' . $folder;
        }

        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        return count($json->Slides->SlideList);
    }

    /*
     * Replaces all instances of old text with new text in a presentation or a particular slide
     * @param string $oldText
     * @param string $newText
     */
    public function replaceText() {
        $parameters = func_get_args();

        //set parameter values
        if (count($parameters) == 2) {
            $oldText = $parameters[0];
            $newText = $parameters[1];
        } else if (count($parameters) == 3) {
            $oldText = $parameters[0];
            $newText = $parameters[1];
            $slideNumber = $parameters[2];
        }
        else
            throw new Exception('Invalid number of arguments');

        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //Build URI to replace text
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . ((isset($parameters[2])) ? '/slides/' . $slideNumber : '') .
                '/replaceText?oldValue=' . $oldText . '&newValue=' . $newText . '&ignoreCase=true';

        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        }
        else
            return $v_output;
    }

    /*
     * Gets all the text items in a slide or presentation
     */
    public function getAllTextItems() {
        $parameters = func_get_args();

        //set parameter values
        if (count($parameters) == 2) {
            $slideNumber = $parameters[0];
            $withEmpty = $parameters[1];
        }


        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //Build URI to get all text items
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName .
                ((isset($parameters[0])) ? '/slides/' . $slideNumber . '/textItems?withEmpty=' . $withEmpty : '/textItems');

        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        return $json->TextItems->Items;
    }

    /*
     * Deletes all slides from a presentation
     */
    public function deleteAllSlides($storageName = '', $folder = '') {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //Build URI to replace text
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/slides';
        if ($folder != '') {
            $strURI .= '?folder=' . $folder;
        }
        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        }
        else
            return $v_output;
    }

    /*
     * Get Document's properties
     */
    public function getDocumentProperties() {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');


        //build URI to merge Docs
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/documentProperties';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);


        if ($json->Code == 200)
            return $json->DocumentProperties->List;
        else
            return false;
    }

    /*
     * Get Resource Properties information like document source format, IsEncrypted, IsSigned and document properties
      @param string $propertyName
     */
    public function getDocumentProperty($propertyName) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($propertyName == '')
            throw new Exception('Property Name not specified');

        //build URI to merge Docs
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/presentation/documentProperties/' . $propertyName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);


        if ($json->Code == 200)
            return $json->DocumentProperty;
        else
            return false;
    }

    /*
     * Remove All Document's properties
     */
    public function removeAllProperties() {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');


        //build URI to merge Docs
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/documentProperties';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE');

        $json = json_decode($responseStream);
        if (is_object($json)) {
            if ($json->Code == 200)
                return true;
            else
                return false;
        }

        return true;
    }

    /*
     * Delete a document property
      @param string $propertyName
     */
    public function deleteDocumentProperty($propertyName) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($propertyName == '')
            throw new Exception('Property Name not specified');

        //build URI to merge Docs
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/documentProperties/' . $propertyName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return true;
        else
            return false;
    }

    /*
     * Set document property
      @param string $propertyName
      @param string $propertyValue
     */
    public function setProperty($propertyName, $propertyValue) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($propertyName == '')
            throw new Exception('Property Name not specified');

        if ($propertyValue == '')
            throw new Exception('Property Value not specified');

        //build URI to merge Docs
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/documentProperties/' . $propertyName;

        $put_data_arr['Value'] = $propertyValue;

        $put_data = json_encode($put_data_arr);

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', 'json', $put_data);

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->DocumentProperty;
        else
            return false;
    }

    /*
     * Add custom document properties
      @param array $propertiesList
     */
    public function addCustomProperty($propertiesList) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($propertiesList == '')
            throw new Exception('Properties not specified');


        //build URI to merge Docs
        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/documentProperties';

        $put_data = json_encode($propertiesList);

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', 'json', $put_data);

        $json = json_decode($responseStream);

        return $json;
    }

    /*
     * saves the document into various formats
     * @param string $outputPath
     * @param string $saveFormat
     */
    public function saveAs($outputPath, $saveFormat,$jpegQuality='', $storageName = '', $folder = '') {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        if ($outputPath == '')
            throw new Exception('Output path not specified');

        if ($saveFormat == '')
            throw new Exception('Save format not specified');



        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '?format=' . $saveFormat;
        if ($folder != '') {
            $strURI .= '&folder=' . $folder;
        }
        if ($storageName != '') {
            $strURI .= '&storage=' . $storageName;
        }
        if ($jpegQuality != '') {
            $strURI .= '&jpegQuality=' . $jpegQuality;
        }
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $output =  $outputPath . Utils::getFileName($this->fileName) . '.' . $saveFormat;
            Utils::saveFile($responseStream,$output);
            return $output;
        }
        else
            return $v_output;
    }

    /*
     * Saves a particular slide into various formats
     * @param number $slideNumber
     * @param string $outputPath
     * @param string $saveFormat
     */
    public function saveSlideAs($slideNumber, $outputPath, $saveFormat) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        if ($outputPath == '')
            throw new Exception('Output path not specified');

        if ($saveFormat == '')
            throw new Exception('Save format not specified');

        if ($slideNumber == '')
            throw new Exception('Slide number not specified');



        $strURI = Product::$baseProductUri . '/slides/' . $this->fileName . '/slides/'.$slideNumber.'?format=' . $saveFormat;

        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $output = $outputPath . Utils::getFileName($this->fileName) . '_' . $slideNumber . '.' . $saveFormat;
            Utils::saveFile($responseStream, $output);
            return $output;
        }
        else
            return $v_output;
    }
}