export default {
    path: '/competitions',
    name: 'competitions',
    redirect: { name: 'CompetitionList' },
    component: {
        template: '<div class="league"><router-view></router-view></div>'
    },
    children: [
        {
            name: 'CompetitionList',
            path: '',
            //component: () => import('../components/Competition/List')
            component: () => import('../components/Competition')
        },
        {
            name: 'CompetitionAdd',
            path: 'new',
            component: () => import('../components/Competition/Add')
        },
        /*{
            name: 'CompetitionUpdate',
            path: ':id/edit',
            component: () => import('../components/Competition/Update')
        },
        {
            name: 'CompetitionShow',
            path: ':id',
            component: () => import('../components/Competition/Show')
        }*/
    ]
};
