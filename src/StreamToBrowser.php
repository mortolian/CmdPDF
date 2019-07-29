<?php

namespace CmdPDF;

/**
 * This is a very simple class which concerns itself with streaming the content of a file
 * to the browser.
 *
 * @todo
 * - If no output filename is specified, the base filename of the source should be used.
 * - cache header option. Possibly setting some simple options.
 *
 * Class StreamToBrowser
 * @package CmdPDF
 * @author Gideon Schoonbee <project@mortolio.com>
 * @license MIT
 */
class StreamToBrowser
{
    const INLINE = "inline";
    const ATTACHMENT = "attachment";

    private $file_path;
    private $file_output;
    private $cache_control = 'max-age=86400';
    private $content_type = 'application/octet-stream';

    public function __construct(String $file_path, String $output_filename = "")
    {
        if (empty($file_path)) {
            throw new Exception("Supply a file location to be streamed.");
        }
        if (empty($output_filename)) {
            throw new Exception("No output filename supplied.");
        }
        if(!file_exists($file_path)) {
           throw new Exception("Source File does not exist.");
        }

        $this->file_path = $file_path;
        $this->file_output = $output_filename;
        $this->getContentType();
    }

    /**
     * This is a simple function to determine file type.
     * This can later be expanded to check for browser safe file types only and
     * return 'application/octet-stream' for anything else which will require to
     * be downloaded instead.
     *
     * @return false|string
     */
    private function getContentType()
    {
        $file_type = mime_content_type($this->file_path);

        if(!empty($file_type)) {
            $this->content_type = $file_type;
        }
    }

    /**
     * This will stream the file to the browser as INLINE or ATTACHMENT.
     *
     * @param String $content_disposition
     */
    public function stream(String $content_disposition = self::ATTACHMENT)
    {
        if (file_exists($this->file_path)) {
            // nifty way to set dynamic content to be cached until it changes.
            $etag = md5(time());

            header('Content-Description: File Transfer');
            header('Content-Type: ' . $this->content_type);
            header('Content-Disposition: ' . $content_disposition . '; filename="' . basename($this->file_path) . '"');
            header('Cache-Control: ' . $this->cache_control);
            header('ETag: ' . $etag);
            header('Pragma: public');
            header('Content-Length: ' . filesize($this->file_path));

            readfile($this->file_path);
            exit;
        } else {
            throw new Exception("File does not exist.");
        }
    }
}