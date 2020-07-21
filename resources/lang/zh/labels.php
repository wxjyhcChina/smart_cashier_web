<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => '全部',
        'yes'     => '是',
        'no'      => '否',
        'custom'  => '自定义',
        'actions' => '操作',
        'active'  => '激活',
        'buttons' => [
            'save'   => '保存',
            'update' => '更新',
        ],
        'hide'              => '隐藏',
        'inactive'          => '禁用',
        'none'              => '空',
        'show'              => '显示',
        'toggle_navigation' => '切换导航',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create'     => '新建角色',
                'edit'       => '编辑角色',
                'management' => '角色管理',

                'table' => [
                    'number_of_users' => '用户数',
                    'permissions'     => '权限',
                    'role'            => '角色',
                    'sort'            => '排序',
                    'total'           => '角色总计',
                ],
            ],

            'users' => [
                'active'              => '激活用户',
                'all_permissions'     => '所有权限',
                'change_password'     => '更改密码',
                'change_password_for' => '为 :user 更改密码',
                'create'              => '新建用户',
                'deactivated'         => '已停用的用户',
                'deleted'             => '已删除的用户',
                'edit'                => '编辑用户',
                'management'          => '用户管理',
                'no_permissions'      => '没有权限',
                'no_roles'            => '没有角色可设置',
                'permissions'         => '权限',

                'table' => [
                    'confirmed'      => '确认',
                    'created'        => '创建',
                    'email'          => '电子邮件',
                    'username'       => '用户名',
                    'id'             => 'ID',
                    'last_updated'   => '最后更新',
                    'name'           => '名称',
                    'no_deactivated' => '没有停用的用户',
                    'no_deleted'     => '没有删除的用户',
                    'roles'          => '角色',
                    'social' => 'Social',
                    'total'          => '用户总计',
                    'first_name'     => '名字',
                    'last_name'      => '姓氏',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => '概述',
                        'history'  => '历史',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => '头像',
                            'confirmed'    => '已确认',
                            'created_at'   => '创建于',
                            'deleted_at'   => '删除于',
                            'email'        => '电子邮件',
                            'last_updated' => '最后更新',
                            'name'         => '名称',
                            'status'       => '状态',
                        ],
                    ],
                ],

                'view' => '查看用户',
            ],
        ],

        'consumeOrder' => [
            'management' => '消费记录管理',
            'active' => '所有消费记录',
            'info' => '消费记录详情',
            'orderFor' => '的消费记录',
            'searchTime' => '搜索时间',
            'search' => '搜索',
            'export' => '导出',

            'dinning_time' => '选择时间段',
            'pay_method' => '支付方式',
            'restaurant_user' => '营业员',


            'table' => [
                'id' => '编号',
                'order_id' => '订单编号',
                'customer' => '用户名',
                'card_id' => '卡编号',
                'price' => '价格',
                'pay_method' => '支付方式',
                'dinning_time' => '用餐时间',
                'consume_category' => '消费类别',
                'department' => '部门',
                'created_at' => '消费时间',
                'restaurant_user_id' => '营业员',
                'status' => '状态'
            ],

            'status' => [
                'refunded' => '已退款',
                'refund_in_progress' => '退款中',
                'wait_pay' => '等待支付',
                'pay_in_progress' => '支付中',
                'complete' => '已完成',
                'closed' => '已关闭',
            ]
        ],

        'rechargeOrder' => [
            'management' => '充值记录管理',
            'active' => '所有充值记录',
            'orderFor' => '的充值记录',

            'table' => [
                'id' => '编号',
                'order_id' => '订单编号',
                'customer_id' => '用户名',
                'card_id' => '卡编号',
                'price' => '价格',
                'pay_method' => '支付方式',
                'restaurant_user_id' => '营业员',
                'status' => '状态',
                'created_at' => '充值时间',
            ],

            'status' => [
                'refunded' => '已退款',
                'refund_in_progress' => '退款中',
                'wait_pay' => '等待支付',
                'pay_in_progress' => '支付中',
                'complete' => '已完成',
                'closed' => '已关闭',
            ]
        ],
        'shop' => [
            'management' => '子商户管理',
            'active' => '所有子商户',
            'edit' => '编辑子商户',
            'create' => '创建子商户',

            'table' => [
                'id' => '编号',
                'name' => '子商户名',
                'default' => '默认商户',
                'created_at' => '创建时间',
            ]
        ],
        'restaurant' => [
            'management' => '餐厅管理',
            'active' => '所有餐厅',
            'edit' => '编辑餐厅',
            'create' => '创建餐厅',
            'info' => '餐厅详情',
            'account' => '餐厅账户',
            'assignCard' => '分配IC卡',
            'shop' => '所有分店',
            'outerDevice' => '所有外接设备',
            'assignDevice' => '分配设备',
            'consumeOrder' => '消费记录',
            'rechargeOrder' => '充值记录',
            'change_password' => '修改密码',
            'change_password_for' => '为 :user 更改密码',
            'uploadImage' => '上传图片',
            'searchTime' => '搜索',
            'export' => '导出',

            'consume_order_table' => [
                'id' => '编号',
                'department' => '部门',
                'consumeCategory' => '消费类别',
                'dinningTime' => '用餐时间',
                'shop' => '商户',
                'goods' => '商品',
                'cash' => '现金金额',
                'cash_count' => '现金人次',
                'card' => '卡金额',
                'card_count' => '卡人次',
                'alipay' => '支付宝金额',
                'alipay_count' => '支付宝人次',
                'wechat' => '微信支付金额',
                'wechat_count' => '微信人次',
                'total' => '合计',
                'total_count' => '合计人次',
            ],

            'table' => [
                'id' => '编号',
                'name' => '餐厅名',
                'address' => '详细地址',
                'contact' => '联系人',
                'telephone' => '联系电话',
                'create_time' => '创建时间'
            ],

            'account_table' => [
                'username'       => '用户名',
                'name'           => '名称',
                'roles'          => '角色',
                'first_name'     => '名字',
                'last_name'      => '姓氏',
                'created'        => '创建',
                'last_updated'   => '最后更新',
            ],

        ],

        'device' => [
            'management' => '设备管理',
            'active' => '所有设备',
            'edit' => '编辑设备',
            'create' => '创建设备',
            'import' => '导入设备',
            'select' => '选择文件',

            'table' => [
                'id' => '编号',
                'serial_id' => '设备串号',
                'created_at' => '创建时间',
            ]
        ],

        'outerDevice' => [
            'management' => '外接设备管理',
            'active' => '所有外接设备',
            'edit' => '编辑外接设备',
            'create' => '创建外接设备',
            'import' => '导入外接设备',
            'select' => '选择文件',

            'table' => [
                'id' => '编号',
                'sources' => '来源',
                'type' => '类型',
                'url' => '外网地址',
                'created_at' => '创建时间',
            ]
        ],

        'card' => [
            'management' => 'IC卡管理',
            'active' => '所有IC卡',
            'edit' => '编辑IC卡',
            'create' => '创建IC卡',
            'import' => '导入IC卡',
            'select' => '选择文件',

            'table' => [
                'id' => '编号',
                'number' => 'IC卡号',
                'internal_number' => 'IC卡内部编码',
                'created_at' => '创建时间',
                'status' => '状态',
            ],

            'status' => [
                'unactivated' => '未使用',
                'activated' => '使用中',
                'lost' => '已挂失'
            ]
        ],

        'versionAndroid' => [
            'management' => '安卓版本管理',
            'active' => '所有安卓版本',
            'edit' => '编辑安卓版本',
            'create' => '创建安卓版本',
            'yes' => '是',
            'no' => '否',

            'table' => [
                'id' => '编号',
                'forced' => '是否必需',
                'version_name' => '版本名',
                'version_code' => '版本码',
                'update_info' => '更新信息',
                'download_url' => '下载地址',
                'created_at' => '创建时间',
            ]
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => '登录',
            'login_button'       => '登录',
            'login_with'         => '使用 :social_media 登录',
            'register_box_title' => '注册',
            'register_button'    => '注册',
            'remember_me'        => '记住我',
        ],

        'contact' => [
            'box_title' => 'Contact Us',
            'button' => 'Send Information',
        ],

        'passwords' => [
            'forgot_password'                 => '忘记密码了？',
            'reset_password_box_title'        => '重置密码',
            'reset_password_button'           => '重置密码',
            'send_password_reset_link_button' => '发送密码重置链接',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

            'state' => [
                'mexico' => 'Mexico State List',
                'us'     => [
                    'us'       => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed'    => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => 'Timezone',
        ],

        'user' => [
            'passwords' => [
                'change' => '更改密码',
            ],

            'profile' => [
                'avatar'             => '头像',
                'created_at'         => '创建于',
                'edit_information'   => '编辑信息',
                'email'              => '电子邮件',
                'last_updated'       => '最后更新',
                'name'               => '名称',
                'update_information' => '更新信息',
            ],
        ],

    ],
];
