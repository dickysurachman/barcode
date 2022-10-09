<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="images/<?php echo Yii::$app->user->identity->foto?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!-- /.search form -->

        <?php 
        if(Yii::$app->user->identity->tipe_user==0){
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Profile','icon' => 'dashboard', 'url'=>['/profile']],
                    ['label' => 'User','icon' => 'dashboard','url'=>['/user']],
                    ['label' => 'Jenis Ternak', 'icon' => 'book', 'url' => ['/rumpun']],
                    ['label' => 'BPTU-HPT', 'icon' => 'copy', 'url' => '#',
                        'items'=>[
                            ['label' => 'Identifikasi Ternak', 'icon' => 'search', 'url' => ['/bib']],
                            ['label' => 'Perkawinan', 'icon' => 'heartbeat', 'url' => ['/bib/kawin']],
                            ['label' => 'Pemeriksaan Kebuntingan', 'icon' => 'paw', 'url' => ['/bib/bunting']],
                            ['label' => 'Kelahiran', 'icon' => 'users', 'url' => ['/bib/lahir']],
                            ['label' => 'Record Ternak', 'icon' => 'spinner', 'url' => ['/bib/umur']],
                            ['label' => 'Kematian', 'icon' => 'minus-square', 'url' => ['/bib/kematian'],],
                            ['label' => 'Distribusi', 'icon' => 'sign-out', 'url' => ['/bib/mutasi'],],
                            ['label' => 'Laporan', 'icon' => 'copy', 'url' => '#',
                                'items'=>[
                                        ['label' => 'Laporan Produksi', 'icon' => 'copy', 'url' => ['/bib/produksi']],
                                        ['label' => 'Laporan Distribusi', 'icon' => 'copy', 'url' => ['/bib/distribusi']],
                                        ['label' => 'Laporan Populasi', 'icon' => 'copy', 'url' => ['/bib/populasi']],
                                        ['label' => 'Laporan Periodik', 'icon' => 'copy', 'url' => ['/bib/report']],
                                ],
                            ],

                        ],
                    ],
                    ['label' => 'BIB', 'icon' => 'copy', 'url' => '#',
                        'items'=>[
                            ['label' => 'Identifikasi Ternak', 'icon' => 'search', 'url' => ['/b']],
                            ['label' => 'Record Ternak', 'icon' => 'spinner', 'url' => ['/b/umur']],
                            ['label' => 'Kematian', 'icon' => 'minus-square', 'url' => ['/b/kematian'],],
                            ['label' => 'Produksi Semen Beku', 'icon' => 'file-code-o', 'url' => ['/b/semen']],
                            ['label' => 'Distribusi Semen Beku', 'icon' => 'sign-out', 'url' => ['/b/distribusi'],],
                            ['label' => 'Laporan', 'icon' => 'copy', 'url' => '#',
                                    'items'=>[
                                    ['label' => 'Laporan Distribusi', 'icon' => 'copy', 'url' => ['/b/print3']],
                                    ['label' => 'Laporan Rekapitulasi', 'icon' => 'copy', 'url' => ['/b/rekapitulasibib']],
                                    ['label' => 'Laporan Periodik', 'icon' => 'copy', 'url' => ['/b/report']],
                            ]
                            ],

                        ],
                    ],
                    ['label' => 'BET', 'icon' => 'copy', 'url' => '#',
                        'items'=>[
                            ['label' => 'Identifikasi Ternak', 'icon' => 'search', 'url' => ['/a']],
                            ['label' => 'Import Semen Beku', 'icon' => 'spinner', 'url' => ['/a/import']],
                            ['label' => 'Perkawinan', 'icon' => 'heartbeat', 'url' => ['/a/kawin']],
                            ['label' => 'Pemeriksaan Kebuntingan', 'icon' => 'paw', 'url' => ['/a/bunting']],
                            ['label' => 'Kelahiran', 'icon' => 'users', 'url' => ['/a/lahir']],
                            ['label' => 'Kematian', 'icon' => 'minus-square', 'url' => ['/a/kematian'],],
                            ['label' => 'Produksi Embrio', 'icon' => 'spinner', 'url' => ['/a/embrio']],
                            ['label' => 'Distribusi Embrio', 'icon' => 'sign-out', 'url' => ['/a/distribusi'],],
                            ['label' => 'Laporan', 'icon' => 'copy', 'url' => '#',
                                'items'=>[
                                ['label' => 'Laporan Stok', 'icon' => 'copy', 'url' => ['/a/print']],
                                ['label' => 'Laporan Donor', 'icon' => 'copy', 'url' => ['/a/report']],
                                ['label' => 'Laporan Resipien', 'icon' => 'copy', 'url' => ['/a/reportres']],
                                ['label' => 'Laporan Calon Bibit', 'icon' => 'copy', 'url' => ['/a/reportcal']],
                                ['label' => 'Laporan Produksi Embrio', 'icon' => 'copy', 'url' => ['/a/reportini']],
                                ]
                            ],


                        ],
                    ],
                    
                ],
            ]
        ) ?>

        <?php
    }else if (Yii::$app->user->identity->tipe_user==1){


        ?>

<?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Rubah Password', 'icon' => 'user', 'url' => ['/site/password']],
                    //['label' => 'Jenis Ternak', 'icon' => 'book', 'url' => ['/rumpun']],
                    ['label' => 'Profile', 'icon' => 'bank', 'url' => ['/site/profile']],
                    ['label' => 'Identifikasi Ternak', 'icon' => 'search', 'url' => ['/individu']],
                    ['label' => 'Perkawinan', 'icon' => 'heartbeat', 'url' => ['/kawin']],
                    ['label' => 'Pemeriksaan Kebuntingan', 'icon' => 'paw', 'url' => ['/pemeriksaan']],
                    ['label' => 'Kelahiran', 'icon' => 'users', 'url' => ['/ternaklahir']],
                    ['label' => 'Record Ternak', 'icon' => 'spinner', 'url' => ['/umur']],
                    ['label' => 'Kematian', 'icon' => 'minus-square', 'url' => ['/kematian'],],
                    ['label' => 'Distribusi', 'icon' => 'sign-out', 'url' => ['/mutasiout'],],
                    ['label' => 'Laporan', 'icon' => 'copy', 'url' => '#',
                        'items'=>[
                                ['label' => 'Laporan Produksi', 'icon' => 'copy', 'url' => ['/site/produksi']],
                                ['label' => 'Laporan Distribusi', 'icon' => 'copy', 'url' => ['/site/distribusi']],
                                ['label' => 'Laporan Populasi', 'icon' => 'copy', 'url' => ['/site/populasi']],
                                ['label' => 'Laporan Periodik', 'icon' => 'copy', 'url' => ['/produksi/report']],
                        ],
                    ],
                    //['label' => 'Logout', 'icon' => 'dashboard', 'url' => ['/site/logout'],'data-method'=>['post']],
                    
                ],
            ]
        ) ?>

        <?php 

            }else if (Yii::$app->user->identity->tipe_user==2){


        ?>

    <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Rubah Password', 'icon' => 'user', 'url' => ['/site/password']],
                    //['label' => 'Jenis Ternak', 'icon' => 'book', 'url' => ['/rumpun']],
                    ['label' => 'Profile', 'icon' => 'bank', 'url' => ['/site/bib']],
                    ['label' => 'Identifikasi Ternak', 'icon' => 'search', 'url' => ['/bibternak']],
                    ['label' => 'Record Ternak', 'icon' => 'spinner', 'url' => ['/recordbib']],
                     //['label' => 'Produksi & Stok', 'icon' => 'file-code-o', 'url' => ['/produksi'],],
                     ['label' => 'Kematian', 'icon' => 'minus-square', 'url' => ['/kemationbib'],],
                    ['label' => 'Produksi Semen Beku', 'icon' => 'file-code-o', 'url' => ['/semen']],
                     //['label' => 'Mutasi Masuk', 'icon' => 'user-plus', 'url' => ['/inbib'],],
                    ['label' => 'Distribusi Semen Beku', 'icon' => 'sign-out', 'url' => ['/bibdistribusi'],],
                    ['label' => 'Laporan', 'icon' => 'copy', 'url' => '#',
                        'items'=>[
                        ['label' => 'Laporan Distribusi', 'icon' => 'copy', 'url' => ['/bibdistribusi/print3']],
                        ['label' => 'Laporan Rekapitulasi', 'icon' => 'copy', 'url' => ['/site/rekapitulasibib']],
                        ['label' => 'Laporan Periodik', 'icon' => 'copy', 'url' => ['/semen/report']],
                        ]
                    ],
                    
                ],
            ]
        ) ?>

        <?php 

        }else if (Yii::$app->user->identity->tipe_user==3){


        ?>


    <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Rubah Password', 'icon' => 'user', 'url' => ['/site/password']],
                    ['label' => 'Profile', 'icon' => 'bank', 'url' => ['/site/bet']],
                    ['label' => 'Identifikasi Ternak', 'icon' => 'search', 'url' => ['/individubet']],
                    ['label' => 'Import Semen Beku', 'icon' => 'spinner', 'url' => ['/betimport']],
                    ['label' => 'Perkawinan', 'icon' => 'heartbeat', 'url' => ['/ternakbetkawin']],
                    ['label' => 'Pemeriksaan Kebuntingan', 'icon' => 'paw', 'url' => ['/betbunting']],
                    ['label' => 'Kelahiran', 'icon' => 'users', 'url' => ['/betlahir']],
                    ['label' => 'Kematian', 'icon' => 'minus-square', 'url' => ['/betmati'],],
                    ['label' => 'Produksi Embrio', 'icon' => 'spinner', 'url' => ['/betembrio']],
                    ['label' => 'Distribusi Embrio', 'icon' => 'sign-out', 'url' => ['/betdis'],],
                    ['label' => 'Laporan', 'icon' => 'copy', 'url' => '#',
                        'items'=>[
                        ['label' => 'Laporan Stok', 'icon' => 'copy', 'url' => ['/betdis/print']],
                        ['label' => 'Laporan Donor', 'icon' => 'copy', 'url' => ['/individubet/report']],
                        ['label' => 'Laporan Resipien', 'icon' => 'copy', 'url' => ['/individubet/reportres']],
                        ['label' => 'Laporan Calon Bibit', 'icon' => 'copy', 'url' => ['/individubet/reportcal']],
                        ['label' => 'Laporan Produksi Embrio', 'icon' => 'copy', 'url' => ['/betdis/report']],
                        ]
                    ],
                    
                ],
            ]
        ) ?>

        <?php 

        }


        ?>

    </section>

</aside>
