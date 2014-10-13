<?php
	$presenter = new Leona\Presenter\ZurbPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pagination" id="leonapaginator">
			<?php echo $presenter->render(); ?>
	</ul>
<?php endif; ?>
