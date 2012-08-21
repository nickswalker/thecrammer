<?xml version="1.0" encoding="UTF-8"?>
 
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method='xml' version='1.0' encoding='UTF-8' indent='yes'/>
<xsl:variable name="count" select="count(/set/terms/term)" data-type='number'/>
 
<xsl:template match="/">
<stats>
<total><xsl:value-of select='sum(/set/terms/term/counter)'/></total>
 <xsl:for-each select="/set/terms/term">
      <xsl:sort select="counter" data-type="number"/>
      <xsl:if test="position() &lt;= 5">
    <top><xsl:value-of select="name"/>
     <!-- <xsl:value-of select="counter"/> --></top>
      </xsl:if>
            <xsl:if test="position() &gt;= $count - 5">
    <bottom><xsl:value-of select="name"/>
     <!-- <xsl:value-of select="counter"/> --></bottom>
      </xsl:if>
    </xsl:for-each>
</stats>
</xsl:template>
</xsl:stylesheet>