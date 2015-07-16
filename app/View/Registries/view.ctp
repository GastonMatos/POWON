



        <div class="large-12 columns ">

            <?php if (empty($ListofItems)):?>
            <h3>  
            <?php echo 'This user has no items in his/her registry'?>
            </h3>
            <?php endif;?>
            
          <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
                <?php foreach ($ListofItems as $ItemsList): ?>
                 <?php if($ItemsList['Registry']['bought'] == 0 || $ItemsList['Registry']['buyer_id'] == $this->Session->read('Auth.User.id')): ?>  
                  <li>
                    <div class="panel text-center">
                      <h3>
                          <?php echo $ItemsList['Registry']['name']; ?>
                          <br />
                          <br />
                      </h3>
                      <div class = "row">
                             <div class="large-6 columns">

                             <?php echo $this->Html->image($ItemsList['Registry']['image']);?>
                             </div>
                             <div class="large-6 columns">
                              <div class ="row">
                              
                                <h5><?php echo 'Description: ';?> </h5>
                              
                                
                                 <?php echo $ItemsList['Registry']['description'] ; ?>
                                
                              </div>
                              <br /><br />
                              <div class ="row">
                                <div class ="large-12 columns">
                                    <div class ="large-3 columns">
                                        <h5><?php echo 'Price: ';?> </h5>
                                    </div>
                                    <div class ="large-9 columns">
                                    <?php echo '$';
                                    echo $ItemsList['Registry']['price']; 
                                    ?>
                                    </div>
                                </div>

                                <div class ="large-12 columns">
                                      <?php if($ItemsList['Registry']['buyer_id'] == $this->Session->read('Auth.User.id') && $ItemsList['Registry']['bought'] == 1 ): ?>
                                              <h3>

                                                    <?php echo $this->Html->link(    "<i class='fi-price-tag large'></i> Gifted", '#', array('class'=>'button medium expand success disabled', 'escape' => false));
                                                   ?>
                                                   </h3>
                                     <?php endif;?>
                                       
                                        <?php if($ItemsList['Registry']['bought'] == 0 ): ?>                                  <h3><?php echo $this->Html->link(    "<i class='fi-price-tag large'></i> Gift", array('action'=>'gift', $ItemsList['Registry']['id']), array('class'=>'button medium expand', 'escape' => false));
                                        ?>
                                        </h3>
                                    <?php endif;?>

                                </div>
                              </div>
                            </div>
                      </div>
                    
                  </li>
                 <? endif;?>
                <?php endforeach ?>
          </ul>
        </div>