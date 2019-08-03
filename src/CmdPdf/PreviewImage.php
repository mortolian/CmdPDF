<?php

namespace CmdPdf;

/**
 * This class concerns itself with creating a preview image from one of the PDF pages, using Image Magick.
 * The class will have a few very simple options available.
 *
 * The default settings will try and improve quality, but can be set down for better file size.
 *
 * Class PreviewImage
 * @package CmdPDFvv
 * @author Gideon Schoonbee <project@mortolio.com>
 * @license MIT
 */
class PreviewImage
{
    const OUTPUT_FILE = 'file';
    const OUTPUT_BASE64 = 'inline';
    const FILE_TYPE_JPG = 'JPG';
    const FILE_TYPE_PNG = 'PNG';
    const FILE_TYPE_TIFF = 'TIFF';

    private $pdf_path;

    private $pdf_page = 1;
    private $image_type = PreviewImage::FILE_TYPE_PNG;
    private $image_density = '150';
    private $image_quality = '100%';
    private $image_depth = '8';
    private $image_size = '100%';
    private $output;

    /**
     * PreviewImage constructor.
     * @param string $pdf_path
     * @throws \Exception
     */
    public function __construct(string $pdf_path)
    {
        if (!file_exists($pdf_path)) {
            throw new \Exception('The PDF does not exist.');
        }

        $this->pdf_path = $pdf_path;
    }

    /**
     * @return string
     */
    public function getImageSize(): string
    {
        return $this->image_size;
    }

    /**
     * @param string $image_size
     * @return PreviewImage
     */
    public function setImageSize(string $image_size): PreviewImage
    {
        $this->image_size = $image_size;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageType(): string
    {
        return $this->image_type;
    }

    /**
     * @param string $image_type
     */
    public function setImageType(string $image_type): void
    {
        $this->image_type = $image_type;
    }

    /**
     * @return string
     */
    public function getImageDensity(): string
    {
        return $this->image_density;
    }

    /**
     * @param string $image_density
     */
    public function setImageDensity(string $image_density): void
    {
        $this->image_density = $image_density;
    }

    /**
     * @return string
     */
    public function getImageQuality(): string
    {
        return $this->image_quality;
    }

    /**
     * @param string $image_quality
     */
    public function setImageQuality(string $image_quality): void
    {
        $this->image_quality = $image_quality;
    }

    /**
     * @return string
     */
    public function getImageDepth(): string
    {
        return $this->image_depth;
    }

    /**
     * @param string $image_depth
     */
    public function setImageDepth(string $image_depth): void
    {
        $this->image_depth = $image_depth;
    }

    /**
     * @param string $output
     * @param int $page
     * @return void
     * @throws \Exception
     */
    public function saveImage(string $output, int $page): void
    {
        if (isset($page) && is_int($page)) {
            $this->pdf_page = $page - 1;
        }

        if (empty($output)) {
            throw new \Exception('No output defined');
        }

        if ($output === PreviewImage::OUTPUT_BASE64) {
            $this->output = sprintf('INLINE:%s:-', $this->image_type);
        } else {
            $this->output = $output;
        }

        $cmd = sprintf('convert -colorspace rgb -trim -flatten -density %s -depth %s -adaptive-resize %s %s -quality %s %s',
            $this->image_density,
            $this->image_depth,
            $this->image_size,
            $this->pdf_path . '[' . $this->pdf_page . ']',
            $this->image_quality,
            $this->output
        );

        $response = exec($cmd, $cmd_output, $cmd_return_code);

        if ($output === PreviewImage::OUTPUT_BASE64) {
            echo $response;
        }

        echo $cmd;

        if ($cmd_return_code !== 0) {
            throw new \Exception('File could not be generated. Exit Code: ' . $cmd_return_code);
        }
    }
}