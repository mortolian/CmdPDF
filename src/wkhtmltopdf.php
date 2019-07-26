<?php
namespace cmdPDF;

/**
 * Class Wkhtmltopdf
 *
 * @author Gideon <gideon@gideon.dev>
 * @license http://www.opensource.org/licenses/MIT
 */

class Wkhtmltopdf
{
    const WKHTHMLTOPDF_BINARY_LOCATION = false;

    private $path = "";
    private $file_name = "";
    private $options = "";

    public function __construct()
    {
        // Check that the WKHTMLTOPDF command is available to use
    }

    public function __destruct()
    {
        $this->deleteTempFiles();
    }

    /**
     * This will remove all the temporary HTML files which was created during the life of this class.
     *
     * @param String $folder
     */
    private function deleteTempFiles(String $folder = __DIR__)
    {
        $cmd = sprintf('rm -f %s/*.html', $folder);
        echo $cmd;
        shell_exec($cmd);
    }

    /**
     * @param String $path
     */
    public function setFilePath(String $path = "")
    {
        if (empty($path)) {
            $this->path = __DIR__;
        } else {
            $this->path = $path;
        }
    }


    /**
     * @param String $file_name
     * @return bool
     */
    public function setFileName(String $file_name = '')
    {
        if (empty($file_name)) {
            return false;
        } else {
            $this->file_name = $file_name;
        }
    }


    /**
     * This method will return the full path.
     *
     * @return bool|string
     */
    private function getFullPath()
    {
        if (!empty($this->path) && !empty($this->file_name)) {
            $array = array($this->path, $this->file_name);
            array_walk_recursive($array, function (&$component) {
                $component = rtrim($component, '/');
            });

            $full_path = implode('/', $array);
            return $full_path;
        }

        if (!empty($this->file_name)) {
            $array = array(__DIR__, $this->file_name);
            array_walk_recursive($array, function (&$component) {
                $component = rtrim($component, '/');
            });

            $full_path = implode('/', $array);
            return $full_path;
        }

        return false;
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
    public function setOptions(Array $options = [])
    {
        if(!empty($options)) {
            $this->options = implode(" ", $options);
        }
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
                    throw new Exception('PDF was not generated successfully.');
            }
        } catch (Exception $e) {
            print_r($exit_code);
            return $e->getMessage();
        }
    }


    private function genCommand()
    {
        return false;
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
        $temp_file = __DIR__ . '/' . md5(time()) . ".html";

        $tsf = fopen($temp_file, 'w');
        fwrite($tsf, $string);
        fclose($tsf);

        $temp_file = "file://" . $temp_file;

        $cmd = sprintf('wkhtmltopdf %s %s %s', $this->options, $temp_file, $this->getFullPath());

        $this->run_wkhtml2pdf_cmd($cmd);

        return False;
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

        $cmd = sprintf('wkhtmltopdf %s %s %s', $this->options, $url, $this->getFullPath());
        echo $this->run_wkhtml2pdf_cmd($cmd);

        return false;
    }
}