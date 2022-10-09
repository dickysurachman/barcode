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
                    ['label' => 'Scan', 'icon' => 'search', 'url' => '#',
                        'items' => [ 
                            ['label' => 'Scan Input', 'icon' => 'clone', 'url' => ['/inputan/index']],
                            ['label' => 'Scan Kirim', 'icon' => 'barcode', 'url' => ['/site/scan']],
                            ['label' => 'Scan Retur', 'icon' => 'info-circle', 'url' => ['/retur/index']],
                            ['label' => 'Scan Kirim Cepat', 'icon' => 'hourglass-start', 'url' => ['/site/scanm']],
                            ['label' => 'Monitoring Kirim Cepat', 'icon' => 'hourglass', 'url' => ['/site/scaninputan']],
                        ],
                    ],
                    ['label' => 'Report', 'icon' => 'print', 'url' => '#',
                         'items' => [ 
                            ['label' => 'Scan Input', 'icon' => 'clone', 'url' => ['/site/reportinput']],
                            ['label' => 'Scan Kirim', 'icon' => 'newspaper-o', 'url' => ['/site/report']],
                            ['label' => 'Scan Retur', 'icon' => 'info-circle', 'url' => ['/site/reportretur']],
                            ['label' => 'Export Scan Kirim CSV', 'icon' => 'history', 'url' => ['/site/reportsumcsv']],
                            ['label' => 'Report Summary Input', 'icon' => 'tags', 'url' => ['/site/reportsuminput']],                   
                            ['label' => 'Report Summary Kirim', 'icon' => 'group', 'url' => ['/site/reportsum']],                   
                            ['label' => 'Report Summary Retur', 'icon' => 'minus-circle', 'url' => ['/site/reportsumretur']],                   
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
                    ['label' => 'Scan', 'icon' => 'search', 'url' => '#',
                        'items' => [ 
                            ['label' => 'Scan Input', 'icon' => 'clone', 'url' => ['/inputan/index']],
                            ['label' => 'Scan Kirim', 'icon' => 'barcode', 'url' => ['/site/scan']],
                            ['label' => 'Scan Retur', 'icon' => 'info-circle', 'url' => ['/retur/index']],
                            ['label' => 'Scan Kirim Cepat', 'icon' => 'hourglass-start', 'url' => ['/site/scanm']],
                            ['label' => 'Monitoring Kirim Cepat', 'icon' => 'hourglass', 'url' => ['/site/scaninputan']],
                        ],
                    ],
                    ['label' => 'Report', 'icon' => 'print', 'url' => '#',
                         'items' => [ 
                            ['label' => 'Scan Input', 'icon' => 'clone', 'url' => ['/site/reportinput']],
                            ['label' => 'Scan Kirim', 'icon' => 'newspaper-o', 'url' => ['/site/report']],
                            ['label' => 'Scan Retur', 'icon' => 'info-circle', 'url' => ['/site/reportretur']],
                            ['label' => 'Export Scan Kirim CSV', 'icon' => 'history', 'url' => ['/site/reportsumcsv']],
                            ['label' => 'Report Summary Input', 'icon' => 'tags', 'url' => ['/site/reportsuminput']],                   
                            ['label' => 'Report Summary Kirim', 'icon' => 'group', 'url' => ['/site/reportsum']],                   
                            ['label' => 'Report Summary Retur', 'icon' => 'minus-circle', 'url' => ['/site/reportsumretur']]
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
