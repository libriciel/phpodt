<?php

namespace PhpOdt;

use DOMDocument;
use PhpOdt\Exceptions\OdtException;
use ZipArchive;

/**
 * The class responsible for creating the xml documents needed
 * to generate an ODT document
 */
class Odt
{
    public const GENERATOR = 'PHP-ODT 0.9.1';

    /**
     * The name of the odt file
     */
//  private $fileName;
    private $manifest;
    private $styles;
    private $document;
    private $documentpath;
    private $documentContent;
    private $officeBody;
    private $officeText;
    private $metadata;
    private $officeMeta;
//  private $officeStyles;
//  private $officeAutomaticStyles;
//  private $permissions;

    private static $instance;

    /**
     * @param $fileName The name of the odt file
     * @param $perm The permissions of the file (optional)
     */
    private function __construct($filePath = null)
    {
        $this->initContent($filePath);
    }

    public static function getInstance($create = null, $filePath = null)
    {
        if (self::$instance == null) {
            self::$instance = new Odt($filePath);
        } elseif ($create) {
            self::$instance = new Odt($filePath);
        }

        return self::$instance;
    }

    /**
     * Creates the manifest document, wich describe all the files contained in
     * the odt document
     */
    public function createManifest()
    {
        $this->manifest = new DOMDocument('1.0', 'UTF-8');
        $root = $this->manifest->createElement('manifest:manifest');
        $root->setAttribute('xmlns:manifest', 'urn:oasis:names:tc:opendocument:xmlns:manifest:1.0');
        $this->manifest->appendChild($root);

        $fileEntryRoot = $this->manifest->createElement('manifest:file-entry');
        $fileEntryRoot->setAttribute('manifest:full-path', '/');
        $fileEntryRoot->setAttribute('manifest:version', '1.1');
        $fileEntryRoot->setAttribute('manifest:media-type', 'application/vnd.oasis.opendocument.text');
        $root->appendChild($fileEntryRoot);

        $fileEntryContent = $this->manifest->createElement('manifest:file-entry');
        $fileEntryContent->setAttribute('manifest:media-type', 'text/xml');
        $fileEntryContent->setAttribute('manifest:full-path', 'content.xml');
        $root->appendChild($fileEntryContent);

        $fileEntryStyles = $this->manifest->createElement('manifest:file-entry');
        $fileEntryStyles->setAttribute('manifest:media-type', 'text/xml');
        $fileEntryStyles->setAttribute('manifest:full-path', 'styles.xml');
        $root->appendChild($fileEntryStyles);

        $fileEntryMeta = $this->manifest->createElement('manifest:file-entry');
        $fileEntryMeta->setAttribute('manifest:media-type', 'text/xml');
        $fileEntryMeta->setAttribute('manifest:full-path', 'meta.xml');
        $root->appendChild($fileEntryMeta);
    }

    /**
     * Creates the styles document, which contains all the styles used in the document
     */
    public function createStyle()
    {
        $this->styles = new DOMDocument('1.0', 'UTF-8');
        $root = $this->styles->createElement('office:document-styles');
        $root->setAttribute('xmlns:office', 'urn:oasis:names:tc:opendocument:xmlns:office:1.0');
        $root->setAttribute('xmlns:style', 'urn:oasis:names:tc:opendocument:xmlns:style:1.0');
        $root->setAttribute('xmlns:text', 'urn:oasis:names:tc:opendocument:xmlns:text:1.0');
        $root->setAttribute('xmlns:fo', 'urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0');
        $root->setAttribute('xmlns:svg', 'urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0');
        $root->setAttribute('xmlns:draw', 'urn:oasis:names:tc:opendocument:xmlns:drawing:1.0');
        $root->setAttribute('xmlns:table', 'urn:oasis:names:tc:opendocument:xmlns:table:1.0');
        $root->setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');
        $root->setAttribute('office:version', '1.1');
        $this->styles->appendChild($root);

        $this->declareFontFaces($root);

        $officeStyles = $this->styles->createElement('office:styles');
        $root->appendChild($officeStyles);

        $officeAutomaticStyles = $this->styles->createElement('office:automatic-styles');
        $root->appendChild($officeAutomaticStyles);

        $officeMasterStyles = $this->styles->createElement('office:master-styles');
        $root->appendChild($officeMasterStyles);
    }

    /**
     * Creates the metadata document, containing the general informations about the document,
     *
     */
    public function createMetadata()
    {
        $this->metadata = new DOMDocument('1.0', 'UTF-8');
        $root = $this->metadata->createElement('office:document-meta');
        $root->setAttribute('xmlns:meta', 'urn:oasis:names:tc:opendocument:xmlns:meta:1.0');
        $root->setAttribute('xmlns:office', 'urn:oasis:names:tc:opendocument:xmlns:office:1.0');
        $root->setAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
        $root->setAttribute('office:version', '1.1');
        $this->metadata->appendChild($root);

        $generator = $this->metadata->createElement('meta:generator', self::GENERATOR);
        $creationDate = $this->metadata->createElement('meta:creation-date', date('Y-m-d\TH:i:s'));
        $this->officeMeta = $this->metadata->createElement('office:meta');
        $this->officeMeta->appendChild($generator);
        $this->officeMeta->appendChild($creationDate);
        $root->appendChild($this->officeMeta);
    }

    /**
     * Declare the fonts that can be used in the document
     *
     * @param DOMElement $rootStyles The root element of the styles document
     */
    public function declareFontFaces($rootStyles)
    {
        $fontFaceDecl = $this->styles->createElement('office:font-face-decls');
        $rootStyles->appendChild($fontFaceDecl);

        $ff = $this->styles->createElement('style:font-face');
        $ff->setAttribute('style:name', 'Courier');
        $ff->setAttribute('svg:font-family', 'Courier');
        $ff->setAttribute('style:font-family-generic', 'modern');
        $ff->setAttribute('style:font-pitch', 'fixed');
        $fontFaceDecl->appendChild($ff);

        $ff = $this->styles->createElement('style:font-face');
        $ff->setAttribute('style:name', 'DejaVu Serif');
        $ff->setAttribute('svg:font-family', '&apos;DejaVu Serif&apos;');
        $ff->setAttribute('style:font-family-generic', 'roman');
        $ff->setAttribute('style:font-pitch', 'variable');
        $fontFaceDecl->appendChild($ff);

        $ff = $this->styles->createElement('style:font-face');
        $ff->setAttribute('style:name', 'Times New Roman');
        $ff->setAttribute('svg:font-family', '&apos;Times New Roman&apos;');
        $ff->setAttribute('style:font-family-generic', 'roman');
        $ff->setAttribute('style:font-pitch', 'variable');
        $fontFaceDecl->appendChild($ff);

        $ff = $this->styles->createElement('style:font-face');
        $ff->setAttribute('style:name', 'DejaVu Sans');
        $ff->setAttribute('svg:font-family', '&apos;DejaVu Sans&apos;');
        $ff->setAttribute('style:font-family-generic', 'swiss');
        $ff->setAttribute('style:font-pitch', 'variable');
        $fontFaceDecl->appendChild($ff);

        $ff = $this->styles->createElement('style:font-face');
        $ff->setAttribute('style:name', 'Verdana');
        $ff->setAttribute('svg:font-family', 'Verdana');
        $ff->setAttribute('style:font-family-generic', 'swiss');
        $ff->setAttribute('style:font-pitch', 'variable');
        $fontFaceDecl->appendChild($ff);
    }

    /**
     * Creates the needed documents and does the needed initialization
     * @return DOMDocument An empty odt document
     */
    public function initContent($fileName = null)
    {

        $this->document = new ZipArchive();
        $this->document->open($fileName, ZIPARCHIVE::CREATE);
        $this->documentpath = $fileName;

        $this->createManifest();
        $this->createStyle();
        $this->createMetadata();

        $this->documentContent = new DOMDocument('1.0', 'UTF-8');
        $this->documentContent->substituteEntities = true;
        $root = $this->documentContent->createElement('office:document-content');
        $root->setAttribute('xmlns:office', 'urn:oasis:names:tc:opendocument:xmlns:office:1.0');
        $root->setAttribute('xmlns:text', 'urn:oasis:names:tc:opendocument:xmlns:text:1.0');
        $root->setAttribute('xmlns:draw', 'urn:oasis:names:tc:opendocument:xmlns:drawing:1.0');
        $root->setAttribute('xmlns:svg', 'urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0');
        $root->setAttribute('xmlns:table', 'urn:oasis:names:tc:opendocument:xmlns:table:1.0');
        $root->setAttribute('xmlns:style', 'urn:oasis:names:tc:opendocument:xmlns:style:1.0');
        $root->setAttribute('xmlns:fo', 'urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0');
        $root->setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');
        $root->setAttribute('office:version', '1.1');
        $this->documentContent->appendChild($root);

        $officeAutomaticStyles = $this->documentContent->createElement('office:automatic-styles');
        $root->appendChild($officeAutomaticStyles);


        $this->officeBody = $this->documentContent->createElement('office:body');
        $root->appendChild($this->officeBody);

        $this->officeText = $this->documentContent->createElement('office:text');
        $this->officeBody->appendChild($this->officeText);

//      return $this->documentContent;
    }


    /**
     * Sets the title of the document
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $element = $this->metadata->createElement('dc:title', $title);
        $this->officeMeta->appendChild($element);
    }

    /**
     * Sets a description for the document
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $element = $this->metadata->createElement('dc:description', $description);
        $this->officeMeta->appendChild($element);
    }

    /**
     * Sets the subject of the document
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $element = $this->metadata->createElement('dc:subject', $subject);
        $this->officeMeta->appendChild($element);
    }

    /**
     * Sets the keywords related to the document
     *
     * @param array $keywords
     */
    public function setKeywords($keywords)
    {
        if (!is_array($keywords)) {
            throw new OdtException('Keywords must be an array.');
        }
        foreach ($keywords as $keyword) {
            $element = $this->metadata->createElement('meta:keyword', $keyword);
            $this->officeMeta->appendChild($element);
        }
    }

    /**
     * Specifies the name of the person who created the document initially
     *
     * @param string $creator
     */
    public function setCreator($creator)
    {
        $element = $this->metadata->createElement('meta:initial-creator', $creator);
        $this->officeMeta->appendChild($element);
    }

    /**
     * Specifies the path des pictures
     *
     * @param string $creator
     */
    public function setFileManifest($namepath)
    {
        $element = $this->manifest->createElement('manifest:file-entry');
        $element->setAttribute('manifest:media-type', '');
        $element->setAttribute('manifest:full-path', $namepath);
        $this->manifest->getElementsByTagName('manifest:manifest')->item(0)->appendChild($element);
    }

    /**
     *
     * @return DOMDocument The document containing all the styles
     */
    public function getStyleDocument()
    {
        return $this->styles;
    }

    public function getDocumentContent()
    {
        return $this->documentContent;
    }

    /**
     *
     * @return ZipArchive
     */
    public function getContent()
    {
        return $this->document;
    }

    /**
     * Write the document to the hard disk
     */
    public function output($perm = 0777)
    {

        //$document->open($fileName, ZIPARCHIVE::CM_STORE);
        $this->document->addFromString('mimetype', 'application/vnd.oasis.opendocument.text');
        // $document->open($fileName, ZIPARCHIVE::OVERWRITE);
        $this->document->addFromString('META-INF/manifest.xml', $this->manifest->saveXML());
        $this->document->addFromString('styles.xml', $this->styles->saveXML());
        $this->document->addFromString('meta.xml', $this->metadata->saveXML());
        $this->document->addFromString('content.xml', html_entity_decode($this->documentContent->saveXML()));

        $this->document->close();

        chmod($this->documentpath, $perm);
    }
}
