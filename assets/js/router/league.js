export default {
    path: '/leagues',
    name: 'leagues',
    redirect: { name: 'LeagueList' },
    component: {
        template: '<div class="league"><router-view></router-view></div>'
    },
    children: [
        {
            name: 'LeagueList',
            path: '',
            //component: () => import('../components/League/List')
            component: () => import('../components/League')
        },
        {
            name: 'LeagueAdd',
            path: 'new',
            component: () => import('../components/League/Add')
        },
        /*{
            name: 'LeagueUpdate',
            path: ':id/edit',
            component: () => import('../components/League/Update')
        },
        {
            name: 'LeagueShow',
            path: ':id',
            component: () => import('../components/League/Show')
        }*/
    ]
};
