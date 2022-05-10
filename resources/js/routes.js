import HomeComponent from './components/HomeComponent.vue'
import OffersComponent from './components/OffersComponent.vue'
import OfferDetailComponent from './components/OfferDetailComponent.vue';
import OfferCreateComponent from './components/OfferCreateComponent.vue';
import MyOffersComponent from './components/MyOffersComponent.vue';
import MyRequestsComponent from './components/MyRequestsComponent.vue';
import MyContactsComponent from './components/MyContactsComponent.vue';
import MyInvitationsComponent from './components/MyInvitationsComponent.vue';
import MyGroupsComponent from './components/MyGroupsComponent.vue';
import MyFavoritesComponent from './components/MyFavoritesComponent.vue';
import MyApplicationsComponent from './components/MyApplicationsComponent.vue';
import RequestDetailComponent from './components/my-requests/RequestDetailComponent.vue';

const routes = [
  {
    path: '/',
    component: HomeComponent,
    name: 'index',
  },
  {
    path: '/offers',
    component: OffersComponent,
    name: 'offers',
  },
  {
    path: '/offers/:offerId',
    component: OfferDetailComponent,
    name: 'offerDetail',
  },
  {
    path: '/submit-listing',
    component: OfferCreateComponent,
    name: 'offerCreate',
  },
  {
    path: '/offers/:offerId/edit',
    component: OfferCreateComponent,
    name: 'offerEdit',
  },
  {
    path: '/my-offers',
    component: MyOffersComponent,
    name: 'myOffers',
  },
  {
    path: '/my-requests',
    component: MyRequestsComponent,
    name: 'myRequests',
  },
  {
    path: '/requests/:requestId',
    component: RequestDetailComponent,
    name: 'requestDetail',
  },
  {
    path: '/my-applications',
    component: MyApplicationsComponent,
    name: 'myApplications',
  },
  {
    path: '/my-contacts',
    component: MyContactsComponent,
    name: 'myContacts',
  },
  {
    path: '/my-invitations',
    component: MyInvitationsComponent,
    name: 'myInvitations',
  },
  {
    path: '/my-groups',
    component: MyGroupsComponent,
    name: 'myGroups',
  },
  {
    path: '/my-favorites',
    component: MyFavoritesComponent,
    name: 'myFavorites',
  },
];

export default routes;
