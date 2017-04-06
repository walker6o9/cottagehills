<?php

/**
 * @file
 * Add to cart message template file.
 *
 * If you want to change the structure of Add to Cart Message popup, then copy
 * this file to your theme's templates directory and do your changes. DO NOT
 * change this file.
 *
 * Available variables:
 * - $line_item: The line item object recently ordered.
 * - $product: The product object recently added to cart.
 * Other variables:
 * - $product_per_unit_price: Per unit price of the product. It has currency
 *   code or symbol attached to it. Currency code or symbol depends on the
 *   AJAX Add to Cart settings.
 * - $product_price_total: Total price of the product. It has currency
 *   code or symbol attached to it. Currency code or symbol depends on the
 *   AJAX Add to Cart settings.
 * - $configuration['success_message']: Success message to be shown on popup.
 * - $configuration['popup_checkout']: Checkout link text.
 * - $checkout_link: Link to checkout page.
 * - $configuration['popup_continue_shopping']: Continue shopping button text.
 * - $configuration['popup_product_name_display']: Check whether to show the
 *   name of product.
 * - $configuration['popup_product_name_label']: Check whether to display name
 *   label.
 * - $product_name: Product name.
 * - $configuration['popup_product_price_display']: Check whether to show the
 *   per unit price of product.
 * - $configuration['popup_product_price_label']: Check whether to display price
 *   label.
 * - $configuration['popup_product_quantity_display']: Check whether to show
 *   quantity of product.
 * - $configuration['popup_product_quantity_label']: Check whether to display
 *   quantity label.
 * - $configuration['popup_product_total_display']: Check whether to show
 *   product total.
 * - $configuration['popup_product_total_label']: Check whether to display total
 *   label.
 */
?>
<div class="add-to-cart-overlay" id="add-to-cart-overlay" data-dismiss="add-cart-message"></div>
<div class="add-cart-message-wrapper">
  <a class="add-to-cart-close" data-dismiss="add-cart-message">
    <span class="element-invisible"><?php print t('Close'); ?></span>
  </a>
  <div class="added-product-message"><?php print $configuration['success_message']; ?></div>

  <div class="new-item-details">
    <?php if ($configuration['popup_product_name_display'] == 1) : ?>
      <div class="product-name">
        <?php if ($configuration['popup_product_name_label'] == 'display_label') : ?>
          <p class="name-label"><?php print t('Name:'); ?></p>
        <?php endif; ?>
        <p class="name"><?php print $product_name; ?></p>
      </div>
    <?php endif;
     if(!empty($configuration['popup_select_sides'])){
      //dsm($line_item_id);
    ?>
    <script>
    function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}   
    function add_sides(event) {
      var x,y;
      var t = document.getElementById("ajax-shopping-cart-table"), // This have to be the ID of the table, not the tag
          d = t.getElementsByTagName("tr")[t.getElementsByTagName("tr").length-1];//['ajax-cart-row'],
          r = d.getElementsByTagName("td")['name'].innerHTML;
          d.getElementsByTagName("td")['name'].innerHTML= " "+ "<? echo /*explode("<br>",*/ $product->title/*)[0]*/; ?>" +"<br><b>Side: </b>"+ this.options[this.selectedIndex].text;
      var ArrayOfSides = new Array();
      var ArrayOfLids = new Array();
      var temp =  new Array();
      var temp1 =  new Array();
          
          x = String(readCookie('productname'));
          //alert("this is x before:"+x);
          x=decodeURI(x);
          //alert("this is x after:"+x);
          var Xarray = new Array();
          Xarray = JSON.parse(x);
          temp = Array(Xarray);
          for(var i = 0; i < temp.length; i++)
          {
              ArrayOfSides = ArrayOfSides.concat(temp[i]);
          }
          ArrayOfSides.push('<?php echo html_entity_decode("<b>".explode(":",$product_name)[0].": </b>".explode(":",$product_name)[1]);?>'+'<br><b>Side: </b>'+ this.options[this.selectedIndex].text);
          updatedString = JSON.stringify(ArrayOfSides).replace(/'/g, "\\'");//replace(/('[a-zA-Z0-9\s]+\s*)'(\s*[a-zA-Z0-9\s]+')/g,"$1\\\'$2");
		  document.cookie =  "productname = " + encodeURI(updatedString);
          
          y = String(readCookie('lid'));
          //alert("this is x before:"+x);
          y=decodeURI(y);
          //alert("this is x after:"+x);
          var Yarray = new Array();
          Yarray = JSON.parse(y);
          temp = Array(Yarray);
          for(var i = 0; i < temp.length; i++)
          {
              ArrayOfLids = ArrayOfLids.concat(temp[i]);
          }
          ArrayOfLids.push("<?php echo $line_item->line_item_label;?>");
          
          //document.cookie =  "side = <b>Side: </b>"+ this.options[this.selectedIndex].text;

          document.cookie =  "lid = " + encodeURI(JSON.stringify(ArrayOfLids));
          //alert("this is the lid:"+"<?php echo $line_item_id;?>");
    } 
    </script>
    <?php
       $aol=false;
       if (isset($_COOKIE['productname'])){
          $Pname = $_COOKIE['productname'];
          $Pname= urldecode($Pname);
          $pname = array();
          $pname = json_decode($Pname);
          
      
          foreach($pname as $i => $item) {
                  $a=explode(":",$pname[$i+1])[0];
                  $b=explode(":",$product_name)[0];
                  if (strpos($a, $b) !== false) {//Here problem when removed and added again
                    $aol= true;
                  }
          }
       }

    if(!$aol){ ?>
      <div class="sides-name">
		<select onchange="add_sides.call(this, event)">
                  <option value="">-- Please Select a Side --</option>
                  <?php
                  foreach($configuration['popup_select_sides']  as $key => $value):
                  if($configuration['popup_select_sides'] == 0){
                    echo '<option value="'.$key.'" selected="selected">'.$value.'</option>'; 
                  }else{
                    echo '<option value="'.$key.'">'.$value.'</option>'; 
                  }
                  endforeach;
                  ?>
  		</select>
      </div>
      <div class="option-button-wrapper">
        <div class="option-button checkout"><?php print $checkout_link; ?></div>
        <div class="option-button continue" data-dismiss="add-cart-message"><?php print $configuration['popup_continue_shopping']; ?></div>
      </div>
    <?php  } }
      if ($configuration['popup_product_price_display'] == 1) : ?>
      <div class="product-cost-incl-tax">
        <?php if ($configuration['popup_product_price_label'] == 'display_label') : ?>
          <p class="cost-incl-tax-label"><?php print t('Price:'); ?></p>
        <?php endif; ?>
        <p class="cost-incl-tax"><?php print $product_per_unit_price; ?></p>
      </div>
    <?php endif; ?>
    <?php if ($configuration['popup_product_quantity_display'] == 1) : ?>
      <div class="product-quantity">
        <?php if ($configuration['popup_product_quantity_label'] == 'display_label') : ?>
          <p class="quantity-label"><?php print t('Quantity:'); ?></p>
        <?php endif; ?>
        <p class="quantity"><?php print intval($quantity); ?></p>
      </div>
    <?php endif; ?>

  </div>
</div>
