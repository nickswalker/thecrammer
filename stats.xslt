<?xml version="1.0" encoding="UTF-8"?>
 
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method='xml' version='1.0' encoding='UTF-8' indent='yes'/>
<xsl:variable name="count" select="count(/set/terms/term)" data-type='number'/>
 
<xsl:template match="/">
<stats>
<answers><xsl:value-of select='sum(/set/terms/term/counter)'/></answers>
 <xsl:for-each select="/set/terms/term">
      <xsl:sort select="counter" data-type="number"/>
      <xsl:if test="position() &lt;= 5">
    <hard>
    <name><xsl:value-of select="name"/></name>
    <counter><xsl:value-of select="counter"/></counter>
    </hard>
      </xsl:if>
            <xsl:if test="position() &gt;= $count - 4">
    <easy>
    <name><xsl:value-of select="name"/></name>
     <counter><xsl:value-of select="counter"/></counter>
     </easy>
      </xsl:if>
    </xsl:for-each>
<title><xsl:value-of select="/set/details/title"/></title>
<description><xsl:value-of select="/set/details/description"/></description>
<total><xsl:value-of select="$count"/></total>
</stats>
</xsl:template>
</xsl:stylesheet>