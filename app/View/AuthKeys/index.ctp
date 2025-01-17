<?php
    echo sprintf('<div%s>', empty($ajax) ? ' class="index"' : '');
    if (!$advancedEnabled) {
        echo '<div class="alert">' . __('Advanced auth keys are not enabled.') . '</div>';
    }
    echo $this->element('genericElements/IndexTable/index_table', [
        'data' => [
            'data' => $data,
            'top_bar' => [
                'pull' => 'right',
                'children' => [
                    [
                        'type' => 'simple',
                        'children' => [
                            'data' => [
                                'type' => 'simple',
                                'fa-icon' => 'plus',
                                'text' => __('Add authentication key'),
                                'class' => 'btn-primary modal-open',
                                'url' => "$baseurl/auth_keys/add" . (empty($user_id) ? '' : ('/' . $user_id)),
                                'requirement' => $canCreateAuthkey
                            ]
                        ]
                    ],
                    [
                        'type' => 'search',
                        'button' => __('Filter'),
                        'placeholder' => __('Enter value to search'),
                        'searchKey' => 'quickFilter',
                    ]
                ]
            ],
            'fields' => [
                [
                    'name' => '#',
                    'sort' => 'AuthKey.id',
                    'data_path' => 'AuthKey.id',
                ],
                [
                    'name' => __('User'),
                    'sort' => 'User.email',
                    'data_path' => 'User.email',
                    'element' => empty($user_id) ? 'links' : 'generic_field',
                    'url' => $baseurl . '/users/view',
                    'url_params_data_paths' => ['User.id'],
                    'requirement' => $me['Role']['perm_admin'] || $me['Role']['perm_site_admin'],
                ],
                [
                    'name' => __('Auth Key'),
                    'sort' => 'AuthKey.authkey_start',
                    'element' => 'authkey',
                    'data_path' => 'AuthKey',
                ],
                [
                    'name' => __('Expiration'),
                    'sort' => 'AuthKey.expiration',
                    'data_path' => 'AuthKey.expiration',
                    'element' => 'expiration'
                ],
                [
                    'name' => ('Last used'),
                    'data_path' => 'AuthKey.last_used',
                    'element' => 'datetime',
                    'requirements' => $keyUsageEnabled,
                    'empty' => __('Never'),
                ],
                [
                    'name' => __('Comment'),
                    'sort' => 'AuthKey.comment',
                    'data_path' => 'AuthKey.comment',
                ],
                [
                    'name' => __('Allowed IPs'),
                    'data_path' => 'AuthKey.allowed_ips',
                ],
            ],
            'title' => empty($ajax) ? __('Authentication key Index') : false,
            'description' => empty($ajax) ? __('A list of API keys bound to a user.') : false,
            'pull' => 'right',
            'actions' => [
                [
                    'url' => $baseurl . '/auth_keys/view',
                    'url_params_data_paths' => array(
                        'AuthKey.id'
                    ),
                    'icon' => 'eye',
                    'dbclickAction' => true,
                    'title' => 'View auth key',
                ],
                [
                    'url' => $baseurl . '/auth_keys/edit',
                    'url_params_data_paths' => array(
                        'AuthKey.id'
                    ),
                    'icon' => 'edit',
                    'title' => 'Edit auth key',
                ],
                [
                    'class' => 'modal-open',
                    'url' => "$baseurl/authKeys/delete",
                    'url_params_data_paths' => ['AuthKey.id'],
                    'icon' => 'trash',
                    'title' => __('Delete auth key'),
                ]
            ]
        ]
    ]);
    echo '</div>';
    if (empty($ajax)) {
        echo $this->element('/genericElements/SideMenu/side_menu', $menuData);
    }
?>
<script type="text/javascript">
    var passedArgsArray = <?php echo $passedArgs; ?>;
    $(function() {
        $('#quickFilterButton').click(function() {
            runIndexQuickFilter();
        });
    });
</script>
