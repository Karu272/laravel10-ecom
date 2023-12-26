<div class="col-md-6 col-lg-3 mb-2 mt-1">
    <span style="background-color: white;">&nbsp;FOUND {{ count($categoryProducts)}} RESULTS&nbsp;</span>
    <nav aria-label="breadcrumb">
        <ol style="background-color: white;" class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a>&nbsp;&rarr;<?php echo $getCategoriesDetails['breadcrumbs']; ?></li>
        </ol>
      </nav>
</div>
