# What is phpodt?

phpodt is a PHP library that help you create an ODT (Open Document Text) file, partially compliant with the Oasis OpenDocument specifications v1.1.

It was initially developed by [_Issam RACHDI_ on SourceForge](https://sourceforge.net/projects/php-odt/) in 2014.

# How it works?

OpenDocument files, "odt" files for example, are actually ZIP archives. An odt file created with phpodt will have the following structure:

```
ODT file (ZIP archive)
    |
    |--- styles.xml
    |--- content.xml
    |--- meta.xml
    |--- META-INF/
        |
        |--- manifest.xml
```

- styles.xml: Contains the styles used in the document.
- content.xml: Contains the content of the document.
- meta.xml: Here are some information about the document, like the name of the author, the date of creation, a description, etc.
- META-INF/manifest.xml: Specify the files contained in the archive, their names & mime-type.

So when you add some content, the text will be stored in "content.xml"; when you add a style to the text, it is inserted in "styles.xml" file; when you specify the title, description, author or any infomation about the document, it is inserted in "meta.xml" file.

# Requirements

phpodt needs PHP >= 8.1 to work. Also you need the DOM and ZIP extensions installed in your server.
