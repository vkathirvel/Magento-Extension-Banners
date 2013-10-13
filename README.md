// PHTML Usage
echo Mage::helper('banners')->getSlideJsHtml('homebanner');
// XML
<block type="banners/banners" name="someName">
<action method="setIdentifier"><value>homebanner</value></action>
<action method="setBannerType"><value>slidejs</value></action>
</block>
// CMS Short Codes
{{block type="banners/banners" identifier="homepage" banner_type="genericdiv" container_id="id" container_class="class" item_class="itemclass" image_class="imageclass" link_class="linkclass" image_link_container_class="ilcclass" heading_class="hclass" content_class="class"}}
{{block type="banners/banners" identifier="homepage" banner_type="slidejs" container_id="id" container_class="class"}}
{{block type="banners/banners" identifier="homepage" banner_type="jcarousel" container_id="id" container_class="class" li_class="liclass"}}
{{block type="banners/banners" identifier="homepage" banner_type="flexslider" container_class="cclass"}}
{{block type="banners/banners" identifier="homepage" banner_type="bxslider" slider_class="bxslider" container_class="cclass"}}