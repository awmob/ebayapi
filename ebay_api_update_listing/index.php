<?php

//Update single standar listing price and quantity
	echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'><p><h3>Update Item Price and Quantity.</h3>Save in items_to_update.csv.<br><br>Format: sku -tab- ebay id - tab- stock level -tab- price. Separate new line with |.</p><p><a href='updateitem.php'>Update Prices and Quantities</a></p></div>";

//Update variation price and quantity

	echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'><p><h3>Update VARIATION Item Price and Quantity.</h3>Save in varitems_to_update.csv.<br><br>Format: sku -tab- ebay id - tab- stock level -tab- price. Separate new line with |.</p><p><a href='updateitemvar.php'>Update Prices and Quantities</a></p></div>";

//MARK AS SHIPPED AND LEAVE FEEDBACK

	echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'><p><h3>Mark Items as Shipped & Leave Feedback for Buyer.</h3>Save in markshipped.csv.<br>Format: TRANSACTION ID  -tab-  ITEM ID - tab- ORDERNUMBER (leave blank if not part of multi line order) - tab- USERNAME . Separate new line with |.</p><p><a href='mark_shipped.php'>Mark Items as Shipped</a></p></div>";


//SEND SHIPPED MESSAGE

	echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'><p><h3>Send Item Shipped Message.</h3>Save in shippedmsg.csv.<br>Format:  ITEM ID - tab- USERNAME  -tab- MESSAGE . Separate new line with |.</p><p><a href='send_shipped_message.php'>Send Shipped Message</a></p></div>";


//Parse File Exchange
echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'>


<p><h3>Parse eBay Filexchange</h3> Save in ebayfilexchange.csv as PIPE delimited.<br><br>Format: sku -tab- ebay id. No need to separate new line.</p>

<p>OUTPUT is in output/todays date_ebay_filexchange_output.txt</p>


<p><a href='generate_ebay_file_exchange.php'>Parse eBay filexchange</a></p></div>";

//CHECK Transaction Status
echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'>


<p><h3>Check Transaction Status</h3> Save in check_status_items.txt as TAB delimited.<br><br>Format: TRANSACTION ID -tab- ITEM NUMBER -tab- USERNAME. Separate line by pipe</p>



<p><a href='check_status.php'>CHECK Transaction Status</a></p></div>";





//END ITEM
echo "<div style='border-width:2px; border-color: black; border-style: solid; padding:5px;'>


<p><h3>END ITEM.</h3> Save in enditem.csv.<br><br>Format: sku -tab- ebay id. Separate new line with |.</p>


<p><a href='end_item.php'>End Listings</a></p></div>";


?>