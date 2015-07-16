


        <div class="large-12 columns ">


            <div class ="row">
              <div class="large-2 columns">
                 <h6><?php echo $this->Html->link(

              ' <i class="fi-plus large"></i>'.' '.'Add item',
              array(
                  'controller' => 'registries',
                  'action' => 'create',
                  $this->Session->read('Auth.User.id'),
                  'full_base' => true

                      ),
                             array( 'class' => 'button medium expand',
                                    'escape' => false
                           )
                     ); ?></h6>
              </div>
            </div>
          <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
                <?php foreach ($ListofItems as $ItemsList): ?>
                  <li>
                    <div class="panel text-center">
                      <h3>
                          <?php echo $ItemsList['Registry']['name']; ?>
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
                                <div class ="large-3 columns">
                                <h5><?php echo 'Price: ';?> </h5>
                                </div>
                                <div class ="large-9 columns">
                                <?php echo '$';
                                echo $ItemsList['Registry']['price']; 
                                ?>
                                </div>
                              </div>
                            </div>
                      </div>
                    </div>
                  </li>
                <?php endforeach ?>
          </ul>
        </div>