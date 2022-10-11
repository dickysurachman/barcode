<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Yii::$app->homeUrl ?>/images/<?php echo Yii::$app->user->identity->foto?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?php 
        if(Yii::$app->user->identity->tipe_user2==1){
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Rubah Password', 'icon' => 'user', 'url' => ['/site/password']],
                    ['label' => 'User', 'icon' => 'user', 'url' => ['/daftar']],
                    ['label' => 'Perusahaan', 'icon' => 'user', 'url' => ['/perusahaan']],
                ],
            ]
        ) ?>

        <?php
        } 
        else 
        { 
        if(Yii::$app->user->identity->tipe_user==0){
        ?>
        <?=dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [                    
                    ['label' => 'Rubah Password', 'icon' => 'key', 'url' => ['/site/password']],
                    ['label' => 'Data Master', 'icon' => 'database', 'url' => '#',
                        'items' => [     
                            ['label' => 'User', 'icon' => 'user', 'url' => ['/user']],
                            ['label' => 'Perusahaan', 'icon' => 'photo', 'url' => ['/profile/updateperusahaan']],
                            ['label' => 'Grup Kurir', 'icon' => 'motorcycle', 'url' => ['/grup']],
                            ['label' => 'Kurir Identitas', 'icon' => 'rss', 'url' => ['/kurir']],
                        ],
                    ],
                    ['label' => 'Input Data', 'icon' => 'search', 'url' => '#',
                        'items' => [ 
                            ['label' => 'Resi Order', 'icon' => 'clone', 'url' => ['/inputan/index']],
                            ['label' => 'Packing', 'icon' => 'barcode', 'url' => ['/site/scan']],
                            ['label' => 'Retur', 'icon' => 'info-circle', 'url' => ['/retur/index']],
                            ['label' => 'Scan Packing Kilat', 'icon' => 'hourglass-start', 'url' => ['/site/scanm']],
                            ['label' => 'Monitoring Packing Kilat', 'icon' => 'hourglass', 'url' => ['/site/scaninputan']],
                        ],
                    ],
                    ['label' => 'Report', 'icon' => 'print', 'url' => '#',
                         'items' => [ 
                            ['label' => 'Resi Order', 'icon' => 'clone', 'url' => ['/site/reportinput']],
                            ['label' => 'Packing', 'icon' => 'newspaper-o', 'url' => ['/site/report']],
                            ['label' => 'Retur', 'icon' => 'info-circle', 'url' => ['/site/reportretur']],
                            ['label' => 'Total', 'icon' => 'refresh', 'url' => ['/site/reportk']],
                            ['label' => 'CSV File', 'icon' => 'history', 'url' => ['/site/reportsumcsv']],
                            ['label' => 'Belum Terpacking', 'icon' => 'tags', 'url' => ['/site/reportsuminput']],                   
                            ['label' => 'Sudah Terpacking', 'icon' => 'group', 'url' => ['/site/reportsum']],                   
                            ['label' => 'Retur', 'icon' => 'minus-circle', 'url' => ['/site/reportsumretur']],                   
                         ],
                    ],
                ],
            ]
        ) ?>

        <?php
        } else {
            ?>
        <?=dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Rubah Password', 'icon' => 'user', 'url' => ['/site/password']],
                    ['label' => 'Input Data', 'icon' => 'search', 'url' => '#',
                        'items' => [ 
                            ['label' => 'Resi Order', 'icon' => 'clone', 'url' => ['/inputan/index']],
                            ['label' => 'Packing', 'icon' => 'barcode', 'url' => ['/site/scan']],
                            ['label' => 'Retur', 'icon' => 'info-circle', 'url' => ['/retur/index']],
                            ['label' => 'Scan Packing Kilat', 'icon' => 'hourglass-start', 'url' => ['/site/scanm']],
                            ['label' => 'Monitoring Packing Kilat', 'icon' => 'hourglass', 'url' => ['/site/scaninputan']],
                        ],
                    ],
                    ['label' => 'Report', 'icon' => 'print', 'url' => '#',
                         'items' => [ 
                            ['label' => 'Resi Order', 'icon' => 'clone', 'url' => ['/site/reportinput']],
                            ['label' => 'Packing', 'icon' => 'newspaper-o', 'url' => ['/site/report']],
                            ['label' => 'Retur', 'icon' => 'info-circle', 'url' => ['/site/reportretur']],
                            ['label' => 'Total', 'icon' => 'refresh', 'url' => ['/site/reportk']],
                            ['label' => 'CSV File', 'icon' => 'history', 'url' => ['/site/reportsumcsv']],
                            ['label' => 'Belum Terpacking', 'icon' => 'tags', 'url' => ['/site/reportsuminput']],                   
                            ['label' => 'Sudah Terpacking', 'icon' => 'group', 'url' => ['/site/reportsum']],                   
                            ['label' => 'Retur', 'icon' => 'minus-circle', 'url' => ['/site/reportsumretur']],                   
                         ],
                    ],
                ],
            ]
        )?>
            <?php
        }}
        ?>        
    </section>

</aside>
