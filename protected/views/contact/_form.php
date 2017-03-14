<div class="js-toggle-body">
	<div class="row">
		<div class="large-6 column">

			<?php if (isset($model->warnings)) { ?>
				<div class="row">
					<div class="large-12 column">
						<div class="alert-box patient with-icon">
							<?php echo CHtml::errorSummary($model); ?>
						</div>
					</div>
				</div>
			<?php }?>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, 'first_name'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, 'first_name')?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, 'last_name'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, 'last_name')?>
				</div>
			</div>
		</div>
	</div>
</div>
