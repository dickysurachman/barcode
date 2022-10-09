<?php
use yii\helpers\Html;
$notif=0;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php 

            //tgl_cekin

        ?>
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                      <i class="fa fa-bell-o"></i>
                      <?php 
                      if($notif>0){
                        ?>
                      <span class="label label-warning"><?php echo $notif ?></span>
                      <?php } ?>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $notif ?> notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                     
                        <?php 
                            if($notif>0) 
                            echo $notif2;

                        ?>
                    </ul>
                  </li>
                  
                </ul>
              </li>

                <!-- Messages: style can be found in dropdown.less-->
                
                
                <!-- Tasks: style can be found in dropdown.less -->
                
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo Yii::$app->homeUrl ?>/images/<?php echo Yii::$app->user->identity->foto?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"> <?php echo Yii::$app->user->identity->username;?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo Yii::$app->homeUrl ?>/images/<?php echo Yii::$app->user->identity->foto?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?php echo Yii::$app->user->identity->username;?>
                                <!--<small>Member since Nov. 2012</small>-->
                            </p>
                        </li>
                        <!-- Menu Body -->
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                            <?= Html::a(
                                    'Profile',
                                    ['/site/userprofile'], ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                
            </ul>
        </div>
    </nav>
</header>
