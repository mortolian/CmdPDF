<?php

namespace CmdPDF;

/**
 * Class Wkhtmltopdf
 *
 * This class concerns itself with generating a PDF from an HTML document.
 * It can process both HTML URL and STRING to generate the PDF document, however
 * the HTML STRING does not always work well on complex pages.
 *
 * @author Gideon <project@mortolio.com>
 * @license http://www.opensource.org/licenses/MIT
 */
class Wkhtmltopdf
{
    const WKHTHMLTOPDF_BINARY_LOCATION = false;

    private $cache_path = __DIR__ . '/../cache';
    private $file_path = "";
    private $options = "";

    public function __construct()
    {
        $check_wkhtmltopdf = new CheckCmd('wkhtmltopdf');
        $check_wkhtmltopdf->check();
    }

    public function __destruct()
    {
        $this->deleteTempFiles($this->cache_path);
    }

    /**
     * This will remove all the temporary HTML files which was created during the life of this class.
     *
     * @param String $folder
     * @return boolean
     */
    private function deleteTempFiles(String $folder = "")
    {
        $cmd = sprintf('rm -f %s/*.html', $folder);
        exec($cmd, $output, $exit_code);

        if ($exit_code == 0) {
            return true;
        }

        return false;
    }

    /**
     * @param String $path
     */
    public function setFilePath(String $path = "")
    {
        if (!empty($path)) {
            $this->file_path = $path;
        }
    }

    /**
     * This will return the full path.
     *
     * @return bool|string
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * This will accept all WKHTMLTOPDF command line options as an array.
     * Each option will be added to a final string to the command which will be run, seperated with a space.
     *
     * @see https://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @example $mpdf->setOptions(['--collate','--page-size A4']);
     *
     * @param array $options
     * @return string
     */
    public function setOptions(array $options = [])
    {
        if (!empty($options)) {
            $this->options = implode(" ", $options);
        }
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * This will execute the shell command whatever it will be.
     * It will check for the
     *
     * @param String $cmd
     * @return bool|string|null
     */
    private function run_wkhtml2pdf_cmd(String $cmd = "")
    {
        if (empty($cmd)) {
            return false;
        }

        try {
            exec($cmd, $output, $exit_code);

            switch ($exit_code) {
                case '0':
                    return $exit_code;
                    break;
                case '1':
                    return $exit_code;
                    break;
                default:
                    throw new Exception('PDF was not generated successfully. :: ' . $output . '(' . $exit_code . ')');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This will very simply return the best effort version of the command required to
     * create a PDF through wkhtmltopdf.
     *
     * @param String $options
     * @param String $uri
     * @param String $destination_path
     * @return string
     */
    private function genCommand(String $options = "", String $uri = "", String $destination_path = "")
    {
        return sprintf('wkhtmltopdf -q %s %s %s', $options, $uri, $destination_path);
    }

    /**
     * This function will allow you to pass a simple HTML string to WKHTMLTOPDF and it will generate a PDF from it.
     * This does not always work as well as supplying a URL, since the resolving of images etc. may not work as
     * expected.
     *
     * @param String $string
     * @return bool
     */
    public function htmlString2pdf(String $string = "")
    {
        if (empty($string)) {
            return false;
        }

        // write the string to an HTML file
        $temp_file = $this->cache_path . DIRECTORY_SEPARATOR . md5(time()) . ".html";

        $tsf = fopen($temp_file, 'w');
        fwrite($tsf, $string);
        fclose($tsf);

        $temp_file = "file://" . $temp_file;

        $cmd = $this->genCommand($this->getOptions(), $temp_file, $this->getFilePath());
        $this->run_wkhtml2pdf_cmd($cmd);

        return false;
    }

    /**
     * This is for the normal operation of WKHTMLTOPDF where you supply it with the URL you would like to turn into
     * a pdf. This method works the best and produces the best looking consistent results.
     *
     * @param String $url
     * @return bool
     */
    public function url2pdf(String $url = "")
    {
        if (empty($url)) {
            return false;
        }
        $cmd = $this->genCommand($this->getOptions(), $url, $this->getFilePath());
        $this->run_wkhtml2pdf_cmd($cmd);

        return false;
    }
}