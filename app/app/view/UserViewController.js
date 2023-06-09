/*
 * File: app/view/UserViewController.js
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

Ext.define('app.view.UserViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.user',

    singin1: function(button, e, eOpts) {
        const access_token =localStorage.getItem('access_token');

        Ext.Ajax.request({
            url:'http://auth.test/api/auth/logout',
            method:"POST",
            headers:{
                'Authorization':`Bearer ${access_token}`
            },
            success:(response)=>{
                const result = Ext.decode(response.responseText);
                this.getView().destroy();
                localStorage.removeItem('access_token');
                localStorage.removeItem('ttl');
                Ext.create('app.view.App').show();

            },
            failure:(response)=>{
                const result = Ext.decode(response.responseText);
                console.log(result);
            }
        });



    },

    onViewportAfterRender: function(component, eOpts) {
        const access_token =localStorage.getItem('access_token');
        const title = Ext.getCmp('title-admin-user1');
        const role = Ext.getCmp('title-admin-rol1');
        const table = Ext.getCmp('table-complete');
        const tablein = Ext.getCmp('table-incomplete');


        /*myaccount*/
        Ext.Ajax.request({
            url:'http://auth.test/api/auth/myaccount',
            method:'POST',
            headers:{
                'Authorization':`Bearer ${access_token}`,
            },
            success:(response)=>{
                const result = Ext.decode(response.responseText);
                title.el.dom.innerHTML = `Bienvenido ${result.data.name} ${result.data.lastname}`;
                role.el.dom.innerHTML = `Tu rol es ${result.data.role}`;
                console.log(result);

                const filter = result.data.role.find((e)=>e=='user');
                console.log(filter);
                if(result.refresh){
                    localStorage.setItem('');
                }
            },
            failure:(response)=>{
                const result = Ext.decode(response.responseText);
                console.log(result);
            }
        });

        Ext.Ajax.request({
            url:'http://auth.test/api/task/find/all',
            headers:{
                'Authorization':`Bearer ${access_token}`
            },
            success:(response)=>{
                const result = Ext.decode(response.responseText);
                console.log(result);

                $taskComplete = result.data.filter((e)=>e.status===0);
                $taskIncomplete = result.data.filter((e)=>e.status===1);


                table.setStore($taskComplete);
                tablein.setStore($taskIncomplete);


            },
            failure:(response)=>{
                const result = Ext.decode(response.responseText);
                console.log(result);
            }
        });


    }

});
