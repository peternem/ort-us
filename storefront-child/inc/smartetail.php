
<script type="text/javascript">window.BuyLocal=window.BuyLocal||function(){this.domain='buylocalbuynow.com';this.isInited=false;this.isLoaded=false;this.snipQueue=[];this.snipCount=0;var d=this;this.load=function(a,b){try{if(!this.isInited){a=a||'https://'+this.domain+'/js/generate_v1.js';b=b||function(){};var c=document.createElement('script');c.type='text/javascript';if(c.readyState){c.onreadystatechange=function(){if(c.readyState=="loaded"||c.readyState=="complete"){d.onLoad()}}}else{c.onload=function(){d.onLoad()}}c.src=a;document.getElementsByTagName('head')[0].appendChild(c);this.isInited=true}}catch(e){}};this.generate=function(a){try{a.id=this.snipCount++;if(!a.elementId||a.elementId.length==0)document.write('<div id="BLN'+a.id+'"></div>');if(!this.isLoaded){this.snipQueue.push(a)}else{this.display(a)}}catch(e){}}};window.BLN=window.BLN||new window.BuyLocal();window.BLN.load();</script>
<script type="text/javascript">
window.BLN.generate({
accountId: 42, // required
brandId: 1795, // required
supplierId: '', //optional for unrestricted brands, required for restricted brands.
gtins: [<?php
if( have_rows('smartetailing_sku_numbers') ):
    while ( have_rows('smartetailing_sku_numbers') ) : the_row();
        // display a sub field value
        $array[] = get_sub_field('sku_number');
    endwhile;
    $foo = implode(',', $array);
    echo $foo;
else :
    echo "Etail SKU Error!";
endif;
?>], // optional for brand store locator, required for product store locator.
linkType: 'button', // optional - button | link | image - default: image
linkText: 'Buy Local Now', //optional - default: 'Buy Local Now'
imageSrc : '', //optional - used for bl_linkType 'image' - default is generic buy local now button
css: 'button', // optional - default blank
mode: 'layer', // optional - default - layer
width: 800, // optional - default - 800
height: 600, // optional - default - 600
elementId : '' // optional - target an element by id / leave blank to have a div automatically generated inline
});
</script>