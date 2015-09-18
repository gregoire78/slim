<?php
//
// Created by Grégoire JONCOUR on 18/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
?>
<h1>Groupes</h1>
<table class="table table-striped table-hover">
    <tr>
        <th>#</th>
        <th>Noms</th>
    </tr>
    <?php foreach ($groups as $i => $group): ?>
    <tr>
        <td><?= $group->id; ?></td>
        <td><?= $group->name; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
