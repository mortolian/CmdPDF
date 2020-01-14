# Install

To install all you have to do is clone the project into your own project. Because the project is hosted in two
different locations, you will have to fill in the blanks below.

```git clone [git source] [git dest]```

Then you will need to run ```composer install``` on your project. This project uses PSR-4 autoloading.


# Install Dependencies on OS

To use the PDF utility classes you will need to install certain dependencies on the OS. I only test and cover
IOS and Ubuntu, but I am sure you should be able to adapt the below instructions for your OS. I have only tested the
versions listed below, but I am sure that the major version or newer will work.

## Ubuntu 18.04

First update

```sudo apt update```

Install wkhtmltopdf (0.12.5)

```sudo apt install wkhtmltopdf```

Install Qpdf (8.4.2)

```sudo apt install qpdf```

Install ImageMagick (7.0.8)

```sudo apt install imagemagick ghostscript```


## IOS

First update brew

``` brew update```

Install wkhtmltopdf (0.12.5)

```brew install wkhtmltopdf```

Install Qpdf (8.4.2)

```brew install qpdf```

Install ImageMagick (7.0.8)

```
brew install imagemagick
brew install ghostscript
```