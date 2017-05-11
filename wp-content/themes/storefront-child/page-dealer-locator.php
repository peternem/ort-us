<?php get_header(); ?>
<div id="primary" class="content-area">


<div id="main" class="site-main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  

	<div id="dealer_boxes">
		<div class="row-container">
		<header class="page-header"><h1><? the_title(); ?></h1></header>
	    	 <div class="row">
				<div class="the_content grid_6 omega">
	      			<? the_field('left_column'); ?>
	    		</div>
	
	    		<div class="the_content grid_6 omega">
	      			<? the_field('right_column'); ?>
	    		</div>
	    	</div>
    	</div>
  	</div>

  <div id="dealer_map">
    <h3>Search For an Ortlieb Dealer</h3>
    <div class="row-container inner">
    	 <div class="row">
    	 		
		      <div class="grid_4 alpha">
		        <form action="#">
		          <fieldset>
		            <label for="location">City/State</label>
		            <input type="text" name="location" id="location" value="<?= $_GET["location"] ?>" />
		
		            <label for="distance">Distance</label>
		            <select name="distance" id="distance">
		              <option value="10">10 miles</option>
		              <option value="25" selected>25 miles</option>
		              <option value="50">50 miles</option>
		              <option value="100">100 miles</option>
		            </select>
		
		            <div class="buttons">
		              <button type="submit">Find Dealers</button>
		            </div>
		          </fieldset>
		        </form>
		        <div id="results" class="dealer-results">
		        </div>
		      </div>
		      <div id="map" class="grid_8 omega">
		        <div id="map_wrapper" data-api-url="<?= DEALER_API_ENDPOINT ?>"></div>
      		</div>
      	</div>
    </div>
  </div>


<script type="template/underscore" id="dealer_infowindow">
  <div class="dealer_popup">
    <h3><%= title %></h3>
    <dl>
      <dt>Website</dt>
      <dd><a href="<%= website %>" target="_blank"><%= website %></a></dd>

      <dt>Phone number:</dt>
      <dd><%= phone_number %></dd>
    </dl>
    <p>
      <a href="<%= directions_url() %>" target="_blank">Get directions</a>
    </p>
  </div>
</script>

<script type="template/underscore" id="results_template">
  <ul class="dealer-list">
    <% if (!dealers.length) { %>
      <li class="no_results">
        No dealers matched your search criteria.
      </li>
    <% } else { %>
      <% _.each(dealers, function(dealer) { %>
        <li data-id="<%= dealer.id %>">
          <span class="title"><%= dealer.title %></span>
          <small class="phone"><%= dealer.phone_number %></small>
        </li>
      <% }) %>
    <% } %>
  </ul>
</script>


<?php endwhile; ?>

</div>
</div>

<?php get_footer(); ?>
