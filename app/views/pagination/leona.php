<?php
	$presenter = new App\Presenter\LeonaPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pagination" id="leonapaginator">
			<?php echo $presenter->render(); ?>
	</ul>
<?php endif; ?>
