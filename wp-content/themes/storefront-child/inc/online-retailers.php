<?php $themeLink = get_stylesheet_directory_uri(); ?>

<?php if ((have_rows('online_dealers')) || (have_rows('smartetailing_sku_numbers'))): ?>
<div id="onlineDealers" class="online-dlr-wrapper" >
    <h4>RETAIL PARTNERS</h4>
        <div class="online-dealers" >
            
            <ul class="online-list">
                <?php if (have_rows('smartetailing_sku_numbers')): ?>

                    <li class="list-item"><?php $buy_Loco_img = $themeLink . "/images/bln-logo-no-hand-150x23.png"; ?>
                        <script type="text/javascript">window.BuyLocal = window.BuyLocal || function(){this.domain = 'buylocalbuynow.com'; this.isInited = false; this.isLoaded = false; this.snipQueue = []; this.snipCount = 0; var d = this; this.load = function(a, b){try{if (!this.isInited){a = a || 'https://' + this.domain + '/js/generate_v1.js'; b = b || function(){}; var c = document.createElement('script'); c.type = 'text/javascript'; if (c.readyState){c.onreadystatechange = function(){if (c.readyState == "loaded" || c.readyState == "complete"){d.onLoad()}}} else{c.onload = function(){d.onLoad()}}c.src = a; document.getElementsByTagName('head')[0].appendChild(c); this.isInited = true}} catch (e){}}; this.generate = function(a){try{a.id = this.snipCount++; if (!a.elementId || a.elementId.length == 0)document.write('<div id="BLN' + a.id + '"></div>'); if (!this.isLoaded){this.snipQueue.push(a)} else{this.display(a)}} catch (e){}}}; window.BLN = window.BLN || new window.BuyLocal(); window.BLN.load();</script>
                        <script type="text/javascript">
                            window.BLN.generate({
                            accountId: 42, // required
                                    brandId: 1795, // required
                                    supplierId: '', //optional for unrestricted brands, required for restricted brands.
                                    gtins: [<?php
            while (have_rows('smartetailing_sku_numbers')) : the_row();
                // display a sub field value
                $array[] = get_sub_field('sku_number');
            endwhile;
            $foo = implode(',', $array);
            echo $foo;
            ?>], // optional for brand store locator, required for product store locator.
                                    linkType: 'image', // optional - button | link | image - default: image
                                    linkText: 'Buy Local Now', //optional - default: 'Buy Local Now'
                                    imageSrc : '<?php echo $buy_Loco_img; ?>', //optional - used for bl_linkType 'image' - default is generic buy local now button
                                    css: 'button', // optional - default blank
                                    mode: 'layer', // optional - default - layer
                                    width: 800, // optional - default - 800
                                    height: 600, // optional - default - 600
                                    elementId : '' // optional - target an element by id / leave blank to have a div automatically generated inline
                            });
                        </script>
                     
                    </li>   
                <?php endif; ?> 
                <?php
                $pop_enable = 0;
                while (have_rows('online_dealers')): the_row();
                    $name = get_sub_field('name');
                    $image = get_sub_field('logo');
                    $link = get_sub_field('product_url');
                    $selected = get_sub_field('pop_up');

                    if ($selected):
                        $pop_enable = 1;
                    endif;
                    ?>
                    <?php if (!$selected): ?>  
                        <li class="list-item">

                            <?php if ($image): ?>
                                <a href="<?php echo $link; ?>" target="_blank">
                                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" class="img-responsive" />
                                </a> 
                            <?php else: ?>
                                <a href="<?php echo $link; ?>" target="_blank"><?php echo $name; ?></a> 
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>

                <?php endwhile; ?>
                <?php //if ($pop_enable == 1): ?>  
<!--                    <li>
                        <a href="#modal-dealers" name="modal" class="btn modal-btn">More Retailers <i class="fa fa-external-link" aria-hidden="true"></i></a>
                    </li>-->
                <?php //endif; ?>
            </ul>
        </div>  
    </div>
    <?php endif; ?>




<div id="modal-dealers" class="modal-popup">
    <a href="#" id="close" class="close_btn" title="Close"><i class="fa fa-times" aria-hidden="true"></i></a>
    <div class="modal-container">
        <header><h3>Online Retailers</h3></header>
        <div class="modal-content">
            <?php if (have_rows('online_dealers')): ?>
                <div class="online-dealers" >
                    <ul class="pop">
                        <?php
                        $pop_count = 0;
                        $odd = "";
                        while (have_rows('online_dealers')): the_row();
                            $name1 = get_sub_field('name');
                            $image1 = get_sub_field('logo');
                            $link1 = get_sub_field('product_url');
                            $selected1 = get_sub_field('pop_up');
                            ?>

                            <?php if ($selected1): ?>  
                                <?php
                                $pop_count++;
                                if ($pop_count % 2) {
                                    $odd = "odd-row";
                                } else {
                                    $odd = "even-row";
                                }
                                ?>
                                <li class="list-item <?php echo $odd; ?>" data-count="<?php echo $pop_count; ?>">
                                    <div class="dlr-link">
                                        <ul>
                                            <li><?php echo $name1; ?></li>
                                            <li><a href="<?php echo $link1; ?>" target="_blank">Buy Now! </a></li>
                                        </ul>
                                    </div>
                                    <div class="dlr-logo">
                                        <?php if ($image1['url']) { ?>
                                            <a href="<?php echo $link1; ?>" target="_blank"><img src="<?php echo $image1['url']; ?>" alt="<?php echo $image1['alt'] ?>" class="img-responsive" /></a>
                                            <?php } ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </div>  
            <?php endif; ?>

        </div>
    </div>
</div>