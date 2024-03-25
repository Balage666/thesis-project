describe('Customer user explores the site', () => {

    const testUserDetails = {

        name: 'Username Changed',
        email: 'useremail.changed@bluvenue.tp',
        countryIso2Code: 'US',
        stateIso2Code: 'AK',
        postalCode: '99501',
        address: 'Cypress, Testing St. 20th',
        phone: '1234567899',

    }

    function triggerHTTPresponse(url) {

        cy.request({
            method: 'GET',
            url: url,
            failOnStatusCode: false
        }).as(`get-url`);

        cy.get('@get-url').then((resp) => { expect(resp.status).to.eq(403);
            expect(resp.statusText).to.have.string('Forbidden') })

    }

    function successfullyRedirectsTo(url) {

        cy.visit(`${url}`);
        cy.url().should('include', `${url}`);

    }

    const customerCredentials = {
        name: 'Only Customer',
        email: 'only.customer@bluevenue.tp',
        password: 'customer'
    }

    const storefront = '/storefront';

    const routes = [
        ['/storefront', () => successfullyRedirectsTo(storefront)],
        ['/auth/log-in', () => successfullyRedirectsTo(storefront)],
        ['/auth/sign-up', () => successfullyRedirectsTo(storefront)],
        ['/dashboard/main', () => triggerHTTPresponse('/dashboard/main')],
        ['/dashboard/charts', () => triggerHTTPresponse('/dashboard/charts')],
        ['/user-management/list', () => triggerHTTPresponse('/user-management/list')],
        ['/user-management/create', () => triggerHTTPresponse('/user-management/create')],
        ['/user-management/show/1', () => triggerHTTPresponse('/user-management/show/1')],
        ['/user-management/edit/1', () => triggerHTTPresponse('/user-management/edit/1')],
        ['/product-management/list', () => triggerHTTPresponse('/product-management/list')],
        ['/product-management/create', () => triggerHTTPresponse('/product-management/create')],
        ['/product-management/show/1', () => successfullyRedirectsTo('/product-management/show/1')],
        ['/product-management/edit/1', () => triggerHTTPresponse('/product-management/edit/1')],
        ['/category-management/list', () => triggerHTTPresponse('/category-management/list')],
        ['/users/profile/1', () => successfullyRedirectsTo('/users/profile/1')],
        ['/order-management/list/all', () => triggerHTTPresponse('/order-management/list/all')],
        ['/order-management/order/1', () => triggerHTTPresponse('/order-management/order/1')]
    ];

    beforeEach(() => {

        cy.login({ name: customerCredentials.name });

    })

    routes.forEach((element) => {

        const [url, fireTest] = element;
        it(`tries to access ${url} page`, () => {

            fireTest();

        })

    })

    it('opens their own profile page' , () => {

        cy.visit('/storefront');

        cy.get('div.m-auto > .nav-item > .nav-link').click();

        cy.get('.dropdown-menu > :nth-child(2) > .dropdown-item').click();

        cy.get('button[data-cy="toggle-edit-mode"]').should('be.visible');

        cy.get('button[data-cy="request-seller-role"]').should('be.visible');

        cy.get('button[data-cy="toggle-edit-mode"]').click();

        cy.get('#name').should('be.visible');
        cy.get(':nth-child(1) > :nth-child(2) > form > .btn').should('be.visible');

        cy.get('#email').should('be.visible');
        cy.get(':nth-child(3) > :nth-child(2) > form > .btn').should('be.visible');

        cy.get('.col-sm-6.text-center > .text-secondary').should('be.visible');

        cy.get('.container-img > .btn').should('be.visible');

        cy.get('#accordionAddresses > .accordion-item').should('be.visible');

        cy.get('#collapseAddresses > .accordion-body').find('button').should('be.enabled').and('be.visible');
        cy.get('#collapseAddresses > .accordion-body').should('contain.text', 'There are no addresses!');

        cy.get('#accordionPhones > .accordion-item').should('be.visible');

        cy.get('#collapsePhones > .accordion-body').find('button').should('be.enabled').and('be.visible');
        cy.get('#collapsePhones > .accordion-body').should('contain.text', 'There are no available phone numbers!');

        cy.get('#headingFavorites').should('be.visible');
        cy.get('#headingFavorites > .accordion-button').should('have.class', 'collapsed');

        cy.get('#headingOrders').should('be.visible');
        cy.get('#headingOrders > .accordion-button').should('have.class', 'collapsed');

        cy.get('#accordionCreatedProducts > .accordion-item').should('be.visible');
        cy.get('#collapseCreatedProducts > .accordion-body').should('contain.text', 'Such emptiness!');
    })

    it('manages their account on their profile page' , { retries: 0 }, () => {

        cy.currentUser().then((user) => {

            cy.visit(`users/profile/${user.id}`);
        })

        cy.get('button[data-cy="toggle-edit-mode"]').click();

        cy.get('#name').clear().type(testUserDetails.name);

        cy.get(':nth-child(1) > :nth-child(2) > form > .btn').click();

        cy.get('.toast-body').should('have.text', 'Name modified!');

        cy.get('h4').should('contain.text', testUserDetails.name);

        cy.get(':nth-child(1) > :nth-child(2) > .my-0').should('contain.text', testUserDetails.name);

        cy.get('button[data-cy="toggle-edit-mode"]').click();

        cy.get('#email').clear().type(testUserDetails.email);

        cy.get(':nth-child(3) > :nth-child(2) > form > .btn').click()

        cy.get('.toast-body').should('have.text', 'Email modified!');

        cy.get(':nth-child(3) > :nth-child(2) > .text-secondary').should('contain.text', testUserDetails.email);

        cy.get('button[data-cy="toggle-edit-mode"]').click();

        cy.get('.col-sm-6.text-center > button').click();

        cy.get('.toast-body').should('contain.text', 'Password has been reset');

        cy.get('button[data-cy="request-seller-role"]').click();

        cy.get('.toast-body').should('contain.text', 'Email sent');

        cy.get('.col-lg-4 > .card > .card-body > .d-flex').should('not.have.class', '.btn.btn-secondary');


        cy.get('#collapseAddresses > .accordion-body > .form-outline > .text-end > .btn').click();

        cy.get('#collapseAddresses > .accordion-body > .form-outline > .text-end > .btn').should('contain.text', 'Cancel');

        cy.get('#collapseAddresses > .accordion-body').find('form').should('be.visible');

        cy.get('#region').should('be.disabled');

        cy.get('#country').select(testUserDetails.countryIso2Code).should('have.value', testUserDetails.countryIso2Code);

        cy.get('#region').should('be.enabled');

        cy.get('#region').select(testUserDetails.stateIso2Code).should('have.value', testUserDetails.stateIso2Code);

        cy.get('#postal_zip_code').type(testUserDetails.postalCode);

        cy.get('#address_text').type(testUserDetails.address);

        cy.get('button[data-cy="add-address"]').click();

        cy.get('.toast-body').should('contain.text', 'Address created');

        cy.get('#collapseAddresses > .accordion-body').should('not.contain.text', 'There are no addresses!');

        cy.get('#collapsePhones > .accordion-body > .form-outline > .text-end > .btn').click();

        cy.get('#collapsePhones > .accordion-body > .form-outline > .text-end > .btn').should('contain.text', 'Cancel');

        cy.get('#collapsePhones > .accordion-body').find('form').should('be.visible');

        cy.get('#country').should('be.visible');

        cy.get('#country').select(testUserDetails.countryIso2Code).should('have.value', testUserDetails.countryIso2Code);

        cy.get('#phone_mask').type(testUserDetails.phone);

        cy.get('button[data-cy="add-phone-number"]').click();

        cy.get('.toast-body').should('contain.text', 'Phone number added!');

        cy.get('#collapsePhones > .accordion-body').should('not.contain.text', 'There are no available phone numbers!');

        cy.refreshRoutes();
        cy.refreshDatabase();
        cy.seed();
    })

    it('visits other user\'s profile', () => {

        successfullyRedirectsTo('/users/profile/2');

        cy.get('button[data-cy="toggle-edit-mode"]').should('be.hidden');

        cy.get('#accordionAddresses').should('not.be.visible');

        cy.get('#accordionPhones').should('not.be.visible');

        cy.get('#accordionAddresses').should('not.be.visible');

        cy.get('#accordionFavorites').should('not.be.visible');

        cy.get('#accordionOrders').should('not.be.visible');

    })

    it('surfs on storefront', () => {

        successfullyRedirectsTo(storefront);

        cy.get(':nth-child(1) > .card > .card-body > :nth-child(4) > .btn-outline-danger').click();

        cy.get('[data-cy="favorite-counter"]').should('be.visible');

        cy.get('.nav-item.m-auto > .nav-link').contains('Favorites').click();

        cy.get('.dropdown-item > .row > :nth-child(3)').should('be.visible');

        cy.get('.dropdown-item > .row > :nth-child(3) > button').click();

        cy.wait(3000);

        cy.get('.toast-body').should('contain.text', 'Product removed from favorites!');

        // cy.get(':nth-child(1) > .overflow-y-scroll > :nth-child(1)').check();
        // cy.get(':nth-child(1) > .overflow-y-scroll > :nth-child(1) > #\31 ').check();

        cy.get('input[data-cy="category_14"]').check();

        cy.get('input[data-cy="distributor_2"]').check();

        cy.get('#stock').check();

        cy.get('.align-items-center > :nth-child(1) > .btn').click();

        cy.location('search').should('have.string', 'availability');
        cy.location('search').should('have.string', 'selectedCategories');
        cy.location('search').should('have.string', 'selectedDistributors');

        cy.get('.mt-sm-2 > .btn').click();

        cy.location('search').should('be.empty');




    })

    it('uses filter and buys products', () => {

        successfullyRedirectsTo(storefront);

        cy.get('#stock').check();

        cy.get('.align-items-center > :nth-child(1) > .btn').click();

        cy.location('search').should('have.string', 'availability');

        cy.get('button[data-cy="add-to-cart-product-1"]').click();

        cy.get('button[data-cy="add-to-cart-product-2"]').click();

        cy.get('button[data-cy="add-to-cart-product-3"]').click();

        cy.get('.badge').should('be.visible');

        cy.get('.nav-item.m-auto > .nav-link').contains('Basket').click();

        cy.wait(2000);

        cy.get('.dropdown-menu').contains('View Basket').click();

        cy.url().should('include', 'shopping-basket/view-list');

        cy.get('.btn-info').contains('Checkout').click();

        cy.currentUser().then((user) => {

            const firstName = user.name.split(' ')[0];
            const lastName = user.name.split(' ')[1];
            // console.log(user);
            cy.get('#firstName').should('have.value', firstName);
            cy.get('#lastName').should('have.value', lastName);

            cy.get('#email').should('have.value', user.email);

            cy.get('#phone').type(testUserDetails.phone);

            cy.get('#address').type(testUserDetails.address);

            cy.get('#state').should('be.disabled');

            cy.get('#country').select(testUserDetails.countryIso2Code).should('have.value', testUserDetails.countryIso2Code)

            cy.get('#state').should('be.enabled');

            cy.get('#state').select(testUserDetails.stateIso2Code).should('have.value', testUserDetails.stateIso2Code);

            cy.get('#zip').type(testUserDetails.postalCode);

            cy.get('.mb-3 > .row > :nth-child(2) > .btn').contains('Proceed').click();

            cy.url().should('include', 'storefront');

            cy.get('.toast-body').should('be.visible');

            cy.get('.toast-body').should('have.text', 'Order taken, but its status is unpaid!');
        })


    })

    it('buys product(s) with stored address and phone number', () => {


        cy.currentUser().then((user) => {

            successfullyRedirectsTo(`/users/profile/${user.id}`);
        })


        cy.get('#collapseAddresses > .accordion-body > .form-outline > .text-end > .btn').click();

        cy.get('#collapseAddresses > .accordion-body > .form-outline > .text-end > .btn').should('contain.text', 'Cancel');

        cy.get('#collapseAddresses > .accordion-body').find('form').should('be.visible');

        cy.get('#region').should('be.disabled');

        cy.get('#country').select(testUserDetails.countryIso2Code).should('have.value', testUserDetails.countryIso2Code);

        cy.get('#region').should('be.enabled');

        cy.get('#region').select(testUserDetails.stateIso2Code).should('have.value', testUserDetails.stateIso2Code);

        cy.get('#postal_zip_code').type(testUserDetails.postalCode);

        cy.get('#address_text').type(testUserDetails.address);

        cy.get('button[data-cy="add-address"]').click();

        cy.get('.toast-body').should('contain.text', 'Address created');

        cy.get('#collapseAddresses > .accordion-body').should('not.contain.text', 'There are no addresses!');

        cy.get('#collapsePhones > .accordion-body > .form-outline > .text-end > .btn').click();

        cy.get('#collapsePhones > .accordion-body > .form-outline > .text-end > .btn').should('contain.text', 'Cancel');

        cy.get('#collapsePhones > .accordion-body').find('form').should('be.visible');

        cy.get('#country').should('be.visible');

        cy.get('#country').select(testUserDetails.countryIso2Code).should('have.value', testUserDetails.countryIso2Code);

        cy.get('#phone_mask').type(testUserDetails.phone);

        cy.get('button[data-cy="add-phone-number"]').click();

        cy.get('.toast-body').should('contain.text', 'Phone number added!');

        cy.get('#collapsePhones > .accordion-body').should('not.contain.text', 'There are no available phone numbers!');

        cy.visit('/storefront');

        cy.get('#stock').check();

        cy.get('.align-items-center > :nth-child(1) > .btn').click();

        cy.location('search').should('have.string', 'availability');

        cy.get('button[data-cy="add-to-cart-product-1"]').click();

        cy.get('button[data-cy="add-to-cart-product-2"]').click();

        cy.get('.badge').should('be.visible');

        cy.get('.nav-item.m-auto > .nav-link').contains('Basket').click();

        cy.wait(2000);

        cy.get('.dropdown-menu').contains('View Basket').click();

        cy.url().should('include', 'shopping-basket/view-list');

        cy.get('.btn-info').contains('Checkout').click();

        cy.currentUser().then((user) => {


            cy.get('#firstName').should('have.value', user.name.split(' ')[0]);
            cy.get('#lastName').should('have.value', user.name.split(' ')[1]);

            cy.get('#email').should('have.value', user.email);

            console.log(user);
            cy.get(':nth-child(4) > #phone').select(user.phone_numbers[0].number).should('have.value', user.phone_numbers[0].number);

            cy.wait(2000);

            cy.get('.col-12 > #address').select(user.addresses[0].id).should('have.value', user.addresses[0].id);
        })

        cy.get('.mb-3 > .row > :nth-child(2) > .btn').contains('Proceed').click();

        cy.url().should('include', 'storefront');

        cy.get('.toast-body').should('be.visible');

        cy.get('.toast-body').should('have.text', 'Order taken, but its status is unpaid!');

    })
})
