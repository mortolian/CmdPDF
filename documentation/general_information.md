## General Information

#### Using wkhtml2pdf

##### Command line examples

To create a PDF from html which is piped to the command.
See: https://stackoverflow.com/questions/21864382/is-there-any-wkhtmltopdf-option-to-convert-html-text-rather-than-file

```
echo "<h1>Test</h1> | wkhtml2pdf - test.pdf
```

The general usage would be:

```
wkhtmltopdf http://google.com google.pdf
```

### ImageMagick

Most ideal command for preview image creation
```convert -density 150 tax.pdf[0] -quality 70 -flatten tax.png```


#### Resources
* https://github.com/wkhtmltopdf/wkhtmltopdf
* http://qpdf.sourceforge.net/files/qpdf-manual.html#ref.basic-options
* http://zoomadmin.com/HowToInstall/UbuntuPackage/qpdf
* https://stackoverflow.com/questions/21864382/is-there-any-wkhtmltopdf-option-to-convert-html-text-rather-than-file
* https://imagemagick.org
* https://www.xpdfreader.com


#### Commercial Resources
* http://www.pdf-tools.com
