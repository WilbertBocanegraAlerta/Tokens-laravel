/*
 * File: app/view/Admin.js
 *
 * This file was generated by Sencha Architect version 4.2.9.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 7.3.x Classic library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 7.3.x Classic. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('app.view.Admin', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.admin',

    requires: [
        'app.view.AdminViewModel',
        'app.view.AdminViewController',
        'Ext.form.Label',
        'Ext.button.Button',
        'Ext.grid.Panel',
        'Ext.view.Table',
        'Ext.grid.column.Action'
    ],

    controller: 'admin',
    viewModel: {
        type: 'admin'
    },
    height: 250,
    style: 'background:white;',
    width: 400,

    items: [
        {
            xtype: 'container',
            height: 60,
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'container',
                    flex: 1,
                    style: 'padding:10px 0 10px 20px;',
                    layout: {
                        type: 'vbox',
                        align: 'stretch'
                    },
                    items: [
                        {
                            xtype: 'label',
                            flex: 1,
                            id: 'title-admin-user'
                        },
                        {
                            xtype: 'label',
                            flex: 1,
                            id: 'title-admin-rol'
                        }
                    ]
                },
                {
                    xtype: 'container',
                    flex: 1,
                    style: 'padding:5px; text-transform:uppercase; letter-spacing:0.1;',
                    layout: {
                        type: 'hbox',
                        align: 'stretch',
                        pack: 'end'
                    },
                    items: [
                        {
                            xtype: 'button',
                            style: 'border-radius:10px;',
                            text: 'cerrar sesión',
                            listeners: {
                                click: 'singin'
                            }
                        }
                    ]
                }
            ]
        },
        {
            xtype: 'container',
            flex: 1,
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'gridpanel',
                    flex: 1,
                    id: 'table-user',
                    title: 'Usuarios',
                    columns: [
                        {
                            xtype: 'gridcolumn',
                            flex: 1,
                            dataIndex: 'name',
                            text: 'Nombre'
                        },
                        {
                            xtype: 'gridcolumn',
                            flex: 1,
                            dataIndex: 'lastname',
                            text: 'Apellido'
                        },
                        {
                            xtype: 'gridcolumn',
                            flex: 1,
                            dataIndex: 'email',
                            text: 'Correo'
                        },
                        {
                            xtype: 'actioncolumn',
                            items: [
                                {

                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ],
    listeners: {
        afterrender: 'onViewportAfterRender'
    }

});