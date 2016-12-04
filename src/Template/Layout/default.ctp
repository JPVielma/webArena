<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Web Arena';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><?= $this->Html->link(__($this->fetch('title')), ['action' => 'index']) ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
            <?php
            // session_start();
            if(isset($_SESSION['valid'])){
                echo "<li>".$_SESSION['username']."</li>";
                echo "<li>". $this->Html->link(__('Logout'), ['controller' => 'Arenas', 'action' => 'logout'])."</li>";
            }
            else{
                echo "<li>".$this->Html->link(__('Log In'), ['controller' => 'Arenas', 'action' => 'login'])."</li>
                <li>".$this->Html->link(__('Register'), ['controller' => 'Arenas', 'action' => 'register'])."</li>";
            }

            ?>
                

            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>

    <footer class="top-bar expanded" data-topbar role="navigation">
    <div class="container clearfix">
    <h3>Project webArena-SII1-9-CG</h3>
    <ul class="title-area large-3 medium-4 columns">
        <li>Alexandre DEBRIE</li> 
        <li>Juan Pablo VIELMA</li>
        <li>Joseph CHACHOUA</li>
        <li>Leonard Lys</li>
    </ul>
    </div>
    </footer>
</body>
</html>
