<?php
/*
 * This class contains features to work with charts
 */
namespace Aspose\Cloud\Cells;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Storage\Folder;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class ChartEditor {

	public $fileName = '';
	public $worksheetName = '';

	public function __construct($fileName, $worksheetName) {
		$this->fileName = $fileName;
		$this->worksheetName = $worksheetName;
	}

	/*
	 * Adds a new chart
	 * $chartType
	 * $upperLeftRow
	 * $upperLeftColumn
	 * $lowerRightRow
	 * $lowerRightColumn
	 */
	public function addChart($chartType, $upperLeftRow, $upperLeftColumn, $lowerRightRow, $lowerRightColumn) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts?chartType=' . $chartType . '&upperLeftRow=' . $upperLeftRow . '&upperLeftColumn=' . $upperLeftColumn . '&lowerRightRow=' . $lowerRightRow . '&lowerRightColumn=' . $lowerRightColumn;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder -> GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/*
	 * Deletes a chart
	 * $chartIndex
	 */
	public function deleteChart($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder -> GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

    public function showChartLegend($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/legend';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder -> GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    public function hideChartLegend($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/legend';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder -> GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    public function updateChartLegend($chartIndex,$properties='') {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/legend';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'POST', 'json', $properties);
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save doc on server
            $folder = new Folder();
            $outputStream = $folder -> GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    public function readChartLegend($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/legend';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', 'json', '');
        $json = json_decode($responseStream);
        return $json->Legend;
    }

	/*
	 * Gets ChartArea of a chart
	 * $chartIndex
	 */
	public function getChartArea($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/chartArea';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json -> ChartArea;
	}

	/*
	 * Gets fill format of the ChartArea of a chart
	 * $chartIndex
	 */
	public function getFillFormat($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/chartArea/fillFormat';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json -> FillFormat;
	}

	/*
	 * Gets border of the ChartArea of a chart
	 * $chartIndex
	 */
	public function getBorder($chartIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //check whether workshett name is set or not
        if ($this->worksheetName == '')
            throw new Exception('Worksheet name not specified');
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '/chartArea/border';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json -> Line;
	}

}
