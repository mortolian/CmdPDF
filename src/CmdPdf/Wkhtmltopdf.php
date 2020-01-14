<?php

namespace CmdPdf;

/**
 * Class Wkhtmltopdf
 *
 * This class concerns itself with generating a PDF from an HTML document.
 * It can process both HTML URL and STRING to generate the PDF document, however
 * the HTML STRING does not always work well on complex pages.
 *
 * @author Mortolian <project@mortolio.com>
 * @license http://www.opensource.org/licenses/MIT
 */
class Wkhtmltopdf
{
    /**
     * Content disposition constant properties
     */
    const DISPOSITION_INLINE = 'inline';
    const DISPOSITION_DOWNLOAD = 'attachment';

    /**
     * @var string This is the URL which will be converted to PDF.
     */
    private $url;

    /**
     * @var array This is the value of the WKHTMLTOPDF options which can be set. Refer to WKHTMLTOPDF help / MAN page.
     */
    private $options = [];

    /**
     * Wkhtmltopdf constructor.
     * @param string $url
     * @throws \Exception
     */
    public function __construct(string $url)
    {
        if (empty($url)) {
            throw new \Exception('No URL specified to turn into PDF');
        }

        $this->url = $url;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options = array())
    {
        if(empty($options)) { return; }
        $this->options = implode(" ", $options);
        return;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Saves the PDF to disk.
     *
     * @param string $filepath
     * @return bool
     * @throws \Exception
     */
    public function save(string $filepath)
    {
        if (empty($filepath)) {
            throw new \Exception('No file location specified to save the generated pdf.');
        }

        // Run wkhtmltopdf
        $descriptorspec = array(
            0 => array('pipe', 'w'), // stdout
            1 => array('pipe', 'w'), // stderr
        );
        $process = proc_open('wkhtmltopdf -q ' . $this->options . ' ' . $this->url . ' ' . $filepath, $descriptorspec, $pipes);

        // Read the outputs
        $errors = stream_get_contents($pipes[1]);

        // Close the process
        fclose($pipes[1]);
        proc_close($process);

        if ($errors) {
            throw new \Exception('PDF generation failed: ' . $errors);
        } else {
            return true;
        }
    }

    /**
     * Output's the PDF to the browser for download or display
     *
     * @param string $filename
     * @param string $content_disposition
     * @throws \Exception
     */
    public function download(string $filename = 'download.pdf', string $content_disposition = self::DISPOSITION_INLINE)
    {
        // Run wkhtmltopdf
        $descriptorspec = array(
            0 => array('pipe', 'r'), // stdin
            1 => array('pipe', 'w'), // stdout
            2 => array('pipe', 'w'), // stderr
        );
        $process = proc_open('wkhtmltopdf -q ' . $this->options . ' ' . $this->url . ' -', $descriptorspec, $pipes);

        // Read the outputs
        $pdf = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);

        // Close the process
        fclose($pipes[1]);
        proc_close($process);

        if ($errors) {
            throw new \Exception('PDF generation failed: ' . $errors);
        } else {
            // nifty way to set dynamic content to be cached until it changes.
            $etag = md5(time());

            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: ' . $content_disposition . '; filename="' . basename($filename) . '"');
            header('Cache-Control: max-age=86400');
            header('ETag: ' . $etag);
            header('Pragma: public');
            header('Content-Length: ' . strlen($pdf));

            echo $pdf;
            exit;
        }
    }
}