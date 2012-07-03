<?php 
  use_helper('text');
  use_helper('date');
  use_helper('I18N');
?>
<div id="page">
			<div id="content">
			
			
				<?php
                  foreach($pager->getResults() as $p):
				?>
			<div class="post">
			<h2 class="title">
			  <a href="<?php echo url_for('home/article').'/id/'.$p['id']?>"><?php echo $p->getTitle();?></a>
			</h2>
			<div class="entry">
			  <!-- slika -->
			  <a href="<?php echo url_for('home/article').'/id/'.$p['id']?>">
			  <img src="<?php echo '/sfproject/web/uploads/'.$p['photo']?>" width="138" height="93" class="left">
			  </a>
			<p><?php echo truncate_text($p->getText(),255,'...',true)?></p>
			</div>
			<p class="meta"><a href="#"><?php echo $p->Categories->getName()?></a>&nbsp;&nbsp;&nbsp;
				<?php echo format_datetime($p->getPublishedAt(),'F','','UTF-8')?>
				<a href="<?php echo url_for('home/article').'/id/'.$p->getId()?>" class="permalink"><?php echo __('Read more')?></a> </p>
           </div>
		<?php endforeach; ?>

			<!-- pager code -->
			<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('home', 'category') ?>?page=1">
      <img src="/images/first.png" alt="First page" />
    </a>
 
    <a href="<?php echo url_for('home', 'category') ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <img src="/images/previous.png" alt="Previous page" title="Previous page" />
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('home', 'category') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="<?php echo url_for('home', 'category') ?>?page=<?php echo $pager->getNextPage() ?>">
      <img src="/images/next.png" alt="Next page" title="Next page" />
    </a>
 
    <a href="<?php echo url_for('home', 'category') ?>?page=<?php echo $pager->getLastPage() ?>">
      <img src="/images/last.png" alt="Last page" title="Last page" />
    </a>
  </div>
<?php endif; ?>
<div class="pagination_desc">
  <strong><?php echo $pager->getNbResults() ?></strong> <?php echo __('articles in this category')?>
 
  <?php if ($pager->haveToPaginate()): ?>
    - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
  <?php endif; ?>
</div>
				<!-- end pager code -->
			</div>
			<!-- end #content -->
			<div id="sidebar">
				<ul>
					
					<li>
						<!--h3>Veroeros etiam</h3>
						<p><strong>Morbi sit amet</strong> mauris Nam vitae nibh eu sapien dictum pharetra. Vestibulum elementum neque vel lacus. Proin auctor dolor loremmassa. Phasellus sit. <a href="#">More&hellip;</a></p>
					</li-->
					<?php include_component('home', 'toparticles') ?>
					<!--  here was a list of sidebar links -->
					<?php include_component('home', 'categorieslist') ?>
				</li>
				</ul>
				<?php include_component('home', 'tagcloud') ?>
			</div>
			<!-- end #sidebar -->
			<div style="clear: both;">&nbsp;</div>
			<div id="widebar">
				<!--div id="colA">
					<h3>Volutpat Consequat</h3>
					<dl class="list1">
						<dt>12.17.2007</dt>
						<dd><a href="#">Praesent nonummy sed lorem</a></dd>
						<dt>12.13.2007</dt>
						<dd><a href="#">Mauris sagittis neque nec nisi sed</a></dd>
						<dt>12.05.2007</dt>
						<dd><a href="#">Vel turpis integer leo venenatis</a></dd>
						<dt>12.02.2007</dt>
						<dd><a href="#">Et pharetra quis sed viverra ante</a></dd>
						<dt>11.30.2007</dt>
						<dd><a href="#">Integer leo lorem sed lorem</a></dd>
					</dl>
				</div>
				<div id="colB">
					<h3>Pharetra Sed Tempus</h3>
					<p>Morbi sit amet mauris Nam vitae nibh eu sapien dictum pharetra. Vestibulum elementum neque vel lacus. Lorem ipsum dolor sit dolore phasellus pede lorem proin auctor dolor loremmassa phasellus sit. <a href="#">More&hellip;</a></p>
				</div>
				<!--   here was a nice thumbs html -->
				<?php //include_partial('nice_thumbs') ?>
				
				<div style="clear: both;">&nbsp;</div>
			</div>
			<!-- end #widebar -->
		</div>