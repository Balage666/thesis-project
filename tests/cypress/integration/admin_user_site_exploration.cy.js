describe('Admin user explores the site', () => {

    const adminCredentials = {
        name: 'Admin Istrator',
        email: 'admin@bluevenue.tp',
        password: 'admin'
    }

    beforeEach(() => {
        cy.login({ name: adminCredentials.name })
    })

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

    const storefront = '/storefront';

    const routes = [
        ['/storefront', () => successfullyRedirectsTo(storefront)],
        ['/auth/log-in', () => successfullyRedirectsTo(storefront)],
        ['/auth/sign-up', () => successfullyRedirectsTo(storefront)],
        ['/dashboard/main', () => successfullyRedirectsTo('/dashboard/main')],
        ['/dashboard/charts', () => successfullyRedirectsTo('/dashboard/charts')],
        ['/user-management/list', () => successfullyRedirectsTo('/user-management/list')],
        ['/user-management/create', () => successfullyRedirectsTo('/user-management/create')],
        ['/user-management/show/1', () => successfullyRedirectsTo('/user-management/show/1')],
        ['/user-management/edit/1', () => successfullyRedirectsTo('/user-management/edit/1')],
        ['/product-management/list', () => successfullyRedirectsTo('/product-management/list')],
        ['/product-management/create', () => successfullyRedirectsTo('/product-management/create')],
        ['/product-management/show/1', () => successfullyRedirectsTo('/product-management/show/1')],
        ['/product-management/edit/1', () => successfullyRedirectsTo('/product-management/edit/1')],
        ['/category-management/list', () => successfullyRedirectsTo('/category-management/list')],
        ['/users/profile/1', () => successfullyRedirectsTo('/users/profile/1')],
        ['/order-management/list/all', () => successfullyRedirectsTo('/order-management/list/all')],
        ['/order-management/order/1', () => triggerHTTPresponse('/order-management/order/1')]
    ];


    routes.forEach((element) => {

        const [url, fireTest] = element;
        it(`tries to access ${url} page`, () => {

            fireTest();

        })

    })


    it('tests laravel link', () => {

        successfullyRedirectsTo(storefront);

        cy.get(':nth-child(3) > :nth-child(2) > .text-white').click();

    })

    it('tests inertia.js link', () => {

        successfullyRedirectsTo(storefront);

        cy.get(':nth-child(3) > .text-white').click();

    })


    it('tests vue.js link', () => {

        successfullyRedirectsTo(storefront);

        cy.get(':nth-child(4) > .text-white').click();

    })


    it('tests boostrap link', () => {

        successfullyRedirectsTo(storefront);

        cy.get(':nth-child(5) > .text-white').click();

    })

    it('tests your account link', () => {


        successfullyRedirectsTo(storefront);

        cy.get(':nth-child(5) > p > .text-white').click();
    })

    it('deletes a product', () => {

        successfullyRedirectsTo('/product-management/list');

        cy.get('button[data-bs-target="#open1"]').click();

        cy.get('#open1 > .container-fluid > :nth-child(1) > .col-lg-12 > .card > .card-body > .d-flex > .row > .col-lg-3.mt-md-3 > .btn').click();

        cy.get('.toast-body').should('have.text', 'Product deleted!');

    })

    it('deletes a category', () => {

        successfullyRedirectsTo('/category-management/list');

        cy.get('button[data-bs-target="#open1"]').click();

        cy.get('#open1 > .container-fluid > :nth-child(1) > :nth-child(1) > .card > .card-body > .d-flex > .row > :nth-child(3) > .btn').click();

        cy.get('.toast-body').should('have.text', 'Category deleted!');
    })

    it('deletes an order', () => {
        successfullyRedirectsTo('/order-management/list/all');

        cy.get('button[data-bs-target="#open1"]').click();

        cy.get('#open1 > .container-fluid > :nth-child(1) > .col-md-12 > .card > .card-body > .d-flex > .row > .col-lg-3.mt-md-3 > .btn').click();

        cy.get('.toast-body').should('have.text', 'Order deleted!');
    })

    // it('deletes a user', () => {

    //     successfullyRedirectsTo('/user-management/list');

    //     cy.get('.form-control').type('Customer');

    //     cy.get('.d-flex > .btn').click();

    //     cy.get('.accordion-button')

    //     // cy.get('#open11038 > .container-fluid > .row > .col-12 > .my-3 > .btn').click();

    //     cy.get('.toast-body').should('have.text', 'User deleted');
    // })
})
