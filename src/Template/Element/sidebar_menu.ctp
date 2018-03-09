<ul class="x-navigation x-navigation-custom">
	<li class="xn-logo">
		<?= $this->Html->link('JainThela',array('controller'=>'Admins','action'=>'index'),['escape'=>false]) ?>
		<a href="#" class="x-navigation-control"></a>
	</li>
	<?php
	
	foreach($sidebar_menu as $menu):
		$class='';
		if(empty($menu->parent_id) && empty($menu->children))
		{
			if($this->request->params['controller']==$menu->controller && $this->request->params['action']==$menu->action)
			{
				$class='active';
			}
			?>
			<li class="<?= $class ?>">
				<?= $this->Html->link('<span class="'.$menu->icon.'"></span> <span class="xn-text">'.$menu->name.'</span>',array('controller'=>$menu->controller,'action'=>$menu->action),['escape'=>false]) ?>
			</li> 
			<?php
		}
		else if(empty($menu->parent_id))
		{
			?>
			<li class="xn-openable">
				<?= $this->Html->link('<span class="'.$menu->icon.'"></span> <span class="xn-text">'.$menu->name.'</span>',array(),['escape'=>false]) ?>
				<?php
				
					echo '<ul>';
					foreach($menu->children as $childrens):
						
						if(!empty($childrens->children))
						{
							?>
							<li class="xn-openable">
								<?= $this->Html->link('<span class="'.$childrens->icon.'"></span> <span class="xn-text">'.$childrens->name.'</span>',array(),['escape'=>false]) ?>
								<ul>
									<?php
									foreach($childrens->children as $children_two):
										?>
										<li>
											<?= $this->Html->link('<span class="'.$children_two->icon.'"></span> <span class="xn-text">'.$children_two->name.'</span>',array('controller'=>$children_two->controller,'action'=>$children_two->action),['escape'=>false]) ?>
										<li>
										<?php
									endforeach;
									?>
								</ul>
							</li>
							<?php
						}
						else if(empty($childrens->children))
						{
							?>
							<li>
								<?= $this->Html->link('<span class="'.$childrens->icon.'"></span> <span class="xn-text">'.$childrens->name.'</span>',array('controller'=>$childrens->controller,'action'=>$childrens->action),['escape'=>false]) ?>
							<li>
							<?php
						}
					endforeach;
					echo '</ul>';
				?>
			</li> 
			<?php
		}
	endforeach;
	?>
	
</ul>