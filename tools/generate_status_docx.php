<?php

$source = __DIR__ . '/../docs/Kwetu_PMS_Status_Report.md';
$target = __DIR__ . '/../docs/Kwetu_PMS_Status_Report.docx';
$lines = file($source, FILE_IGNORE_NEW_LINES);
$escape = static fn (string $text): string => htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
$body = '';
foreach ($lines as $line) {
    if ($line === '' || str_starts_with($line, '| ---')) continue;
    $style = null; $text = $line;
    if (preg_match('/^(#{1,3})\s+(.+)$/', $line, $matches)) { $style = ['Heading1','Heading2','Heading3'][strlen($matches[1]) - 1]; $text = $matches[2]; }
    elseif (str_starts_with($line, '- ')) { $style = 'ListParagraph'; $text = '• ' . substr($line, 2); }
    elseif (preg_match('/^\d+\.\s+/', $line)) { $style = 'ListParagraph'; }
    elseif (str_starts_with($line, '|')) { $text = trim(str_replace('|', '   ', $line)); }
    $paragraphStyle = $style ? '<w:pPr><w:pStyle w:val="'.$style.'"/></w:pPr>' : '';
    $body .= '<w:p>'.$paragraphStyle.'<w:r><w:t xml:space="preserve">'.$escape($text).'</w:t></w:r></w:p>';
}
$document = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:body>'.$body.'<w:sectPr><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/></w:sectPr></w:body></w:document>';
$styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:style w:type="paragraph" w:default="1" w:styleId="Normal"><w:name w:val="Normal"/></w:style><w:style w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:rPr><w:b/><w:sz w:val="32"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="Heading2"><w:name w:val="heading 2"/><w:rPr><w:b/><w:sz w:val="26"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="Heading3"><w:name w:val="heading 3"/><w:rPr><w:b/><w:sz w:val="22"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="ListParagraph"><w:name w:val="List Paragraph"/></w:style></w:styles>';
$zip = new ZipArchive(); $zip->open($target, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/><Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/></Types>');
$zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/></Relationships>');
$zip->addFromString('word/document.xml', $document); $zip->addFromString('word/styles.xml', $styles);
$zip->addFromString('word/_rels/document.xml.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
$zip->close();
