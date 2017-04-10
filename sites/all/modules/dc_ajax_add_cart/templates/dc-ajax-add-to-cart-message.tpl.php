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
    ?>
    <script>
/*********************************/

var other_sides='';
/*********************************/

function getSides(line_item_id,callback){
  var sides;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               // sides = this.responseText;
                //alert("Este es el side");
                //alert(this.responseText);
                callback(this.responseText); 
            }else{
              //alert(this.readyState);
              // alert(this.status);
            }
        };
        xmlhttp.open("GET","sites/all/modules/dc_ajax_add_cart/dc_ajax_add_cart.php?q="+line_item_id,false);
        xmlhttp.send();
  }

/*********************************/

function JSON_flatten(data) {
    var result = {};
    function recurse (cur, prop) {
        if (Object(cur) !== cur) {
            result[prop] = cur;
        } else if (Array.isArray(cur)) {
             for(var i=0, l=cur.length; i<l; i++)
                 recurse(cur[i], prop + "[" + i + "]");
            if (l == 0)
                result[prop] = [];
        } else {
            var isEmpty = true;
            for (var p in cur) {
                isEmpty = false;
                recurse(cur[p], prop ? prop+"."+p : p);
            }
            if (isEmpty && prop)
                result[prop] = {};
        }
    }
    recurse(data, "");
    return result;
}

/*********************************/

function saveSides(str1,str2,str3) {
var http = new XMLHttpRequest();
var url = "sites/all/modules/dc_ajax_add_cart/dc_ajax_add_cart.php";
var lid =  "<?php echo($configuration['led']);?>";//"<?php echo $line_item->line_item_id;?>";
var params = "name="+str1+"&middle="+str2+"&sides="+str3+"&lid="+lid;
http.open("POST", url, true);

//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
    }
}
http.send(params);
}

/*********************************/
function asignar(callbak) {
  other_sides= callbak; 
 //alert('THIS IS OTHER SIDES'+other_sides);
}

/*********************************/


function add_sides(event) {
  var led="<? echo $configuration['led']; ?>";
  var x,y;
  var t = document.getElementById("ajax-shopping-cart-table"), // This have to be the ID of the table, not the tag
      d = t.getElementsByTagName("tr")[t.getElementsByTagName("tr").length-1];//['ajax-cart-row'],
      r = d.getElementsByTagName("td")['name'].innerHTML;
  var    pname = "<? echo explode(":",$product->title)[0]; ?>";
  var    pmiddle = "<? echo explode(":",$product->title)[1]; ?>";
  var temp= new Array();
  var tempside="";
  //other_sides=getSides("<? echo $configuration['order_id']; ?>"); 
  //alert(led);
  
  getSides(led,asignar); 
  //other_sides=asignar();

  if (typeof other_sides === 'undefined') {tempside="";
  }else{
  var Xarray = new Array();
          //alert('THIS IS OTHER SIDES INSIDE XARRAY'+other_sides);
          try {
           temp =  JSON.parse(/*JSON_flatten(*/other_sides/*)*/);//other_sides.split("<br>");//
           //temp = Array(Xarray);
           
           for(var i = 0; i < temp.length; i++)
           
           {
              tempside = tempside + "<br>"+ (i+1) +")"+temp[i];+ "<br>";
              //alert("TEMPSIDE inside Xarray:"+tempside);
                            //alert("TEMPSIDE lenght:"+tempside);


           }
          } catch(e) {
            //alert(e);
            tempside=''; i=0;
          } 
  }
  

      var  pside = tempside +"<br>"+ (i+1) +")"+this.options[this.selectedIndex].text;//"<br>"+tempside + "<br>"+this.options[this.selectedIndex].text;
      d.getElementsByTagName("td")['name'].innerHTML= " "+ pname + pmiddle + /*"<br><b>Side: </b>" +*/"<br>"+ pside;
      temp = temp.concat(this.options[this.selectedIndex].text);

      //temp.push(this.options[this.selectedIndex].text);
      updatedString =  JSON.stringify(temp).replace(/'/g, "\\'");//temp.join("<br>");//
      //console.log(updatedString.replace(/['"]+/g, ''));
      updatedString=updatedString.replace(/[\])}[{(]/g, '');
      updatedString = "["+updatedString+"]";
      saveSides(""+pname,""+pmiddle, updatedString);
  }
/*********************************/


    </script>
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
    <?php  }// }
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
