describe('Seller user explores the site', () => {

    const testUserDetails = {

        name: 'Username Changed',
        email: 'useremail.changed@bluvenue.tp',
        countryIso2Code: 'US',
        stateIso2Code: 'AK',
        postalCode: '99501',
        address: 'Cypress, Testing St. 20th',
        phone: '1234567899',

    }

    const testProductDetails = {

        name: 'Cypress',
        description: 'Cypress testing...',
        price: 15,
        stock: 15,


    }

    const testCategoryDetails = {

        name: 'Cypress'

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



    const sellerCredentials = {
        name: 'Sel Ler',
        email: 'sel.ler@bluevenue.tp',
        password: 'seller'
    }


    const storefront = '/storefront';

    const routes = [
        ['/storefront', () => successfullyRedirectsTo(storefront)],
        ['/auth/log-in', () => successfullyRedirectsTo(storefront)],
        ['/auth/sign-up', () => successfullyRedirectsTo(storefront)],
        ['/dashboard/main', () => successfullyRedirectsTo('/dashboard/main')],
        ['/dashboard/charts', () => triggerHTTPresponse('/dashboard/charts')],
        ['/user-management/list', () => triggerHTTPresponse('/user-management/list')],
        ['/user-management/create', () => triggerHTTPresponse('/user-management/create')],
        ['/user-management/show/1', () => triggerHTTPresponse('/user-management/show/1')],
        ['/user-management/edit/1', () => triggerHTTPresponse('/user-management/edit/1')],
        ['/product-management/list', () => successfullyRedirectsTo('/product-management/list')],
        ['/product-management/create', () => successfullyRedirectsTo('/product-management/create')],
        ['/product-management/show/1', () => successfullyRedirectsTo('/product-management/show/1')],
        ['/product-management/edit/1', () => triggerHTTPresponse('/product-management/edit/1')],
        ['/category-management/list', () => successfullyRedirectsTo('/category-management/list')],
        ['/users/profile/1', () => successfullyRedirectsTo('/users/profile/1')],
        ['/order-management/list/all', () => triggerHTTPresponse('/order-management/list/all')],
        ['/order-management/order/1', () => triggerHTTPresponse('/order-management/order/1')]
    ];


    beforeEach(() => {
        cy.login({ name: sellerCredentials.name })
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

        cy.get('.col-lg-4 > .card > .card-body > .d-flex').should('not.have.class', '.btn.btn-secondary');

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
        cy.get('#collapseCreatedProducts > .accordion-body').should('not.contain.text', 'Such emptiness!');
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

        cy.get('.toast-body').should('contain.text', `User's password has been reset by the system!`);

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

    it('creates a category', () => {

        cy.visit('/category-management/list');

        cy.get('.mt-md-0 > .btn').click();

        cy.get('.modal-content').should('be.visible');

        cy.wait(2000);

        cy.get('#category').type(testCategoryDetails.name);

        cy.wait(2000);

        cy.get('.modal-footer > .btn-primary').should('be.enabled');

        cy.get('.modal-footer > .btn-primary').click();

        cy.wait(2000);

        cy.get('.toast-body').should('contain.text', 'Category Added');

        cy.refreshRoutes();
        cy.refreshDatabase();
        cy.seed();

    })

    it('creates a product', () => {

        cy.visit('/product-management/create');

        cy.get('#category').select('__mask_3').should('have.value', '__mask_3');

        cy.get('#input_3').click();

        cy.get('#name').should('be.visible');

        cy.get('#description').should('be.visible');

        cy.get('#price').should('be.visible');

        cy.get('#stock').should('be.visible');

        cy.get('#name').type(testProductDetails.name);

        cy.get('#description').type(testProductDetails.description);

        cy.get('#price').click().clear().type(testProductDetails.price);

        cy.get('#stock').click().clear().type(testProductDetails.stock);

        cy.get('#input_7').click();

        cy.get('#images').should('be.visible');

        cy.get('#input_10').click();

        cy.get('.toast-body').should('contain.text', 'Product created');

        cy.refreshRoutes();
        cy.refreshDatabase();
        cy.seed();

    })

    it('creates a category and a product for it', () => {

        cy.visit('/category-management/list');

        cy.get('.mt-md-0 > .btn').click();

        cy.get('.modal-content').should('be.visible');

        cy.wait(2000);

        cy.get('#category').type(testCategoryDetails.name);

        cy.wait(2000);

        cy.get('.modal-footer > .btn-primary').should('be.enabled');

        cy.get('.modal-footer > .btn-primary').click();

        cy.wait(2000);

        cy.get('.toast-body').should('contain.text', 'Category Added');


        cy.visit('/product-management/create');

        cy.get('#category').select(testCategoryDetails.name).find('option:selected').should('have.text', testCategoryDetails.name);

        cy.get('#input_3').click();

        cy.get('#name').should('be.visible');

        cy.get('#description').should('be.visible');

        cy.get('#price').should('be.visible');

        cy.get('#stock').should('be.visible');

        cy.get('#name').type(testProductDetails.name);

        cy.get('#description').type(testProductDetails.description);

        cy.get('#price').click().clear().type(testProductDetails.price);

        cy.get('#stock').click().clear().type(testProductDetails.stock);

        cy.get('#input_7').click();

        cy.get('#images').should('be.visible');

        cy.get('#input_10').click();

        cy.get('.toast-body').should('contain.text', 'Product created');

    })

})
