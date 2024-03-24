describe('Guest user explores the site' , () => {

    const orderForm = {
        firstName: 'Test',
        lastName: 'User',
        email: 'test.user@testing.com',
        phone: '123456789',
        address: 'Cypress, Testing St. 20th',
        countryIso2Code: 'US',
        stateIso2Code: 'AK',
        postalCode: '99501'
    }

    const logIn = 'log-in'

    const routes = [
        ['/storefront', () => cy.url().should('include', `storefront`)],
        ['/auth/log-in', () => cy.url().should('include', `${logIn}`)],
        ['/auth/sign-up', () => cy.url().should('include', `sign-up`)],
        ['/dashboard/main', () => cy.url().should('include', `${logIn}`)],
        ['/dashboard/charts', () => cy.url().should('include', `${logIn}`)],
        ['/user-management/list', () => cy.url().should('include', `${logIn}`)],
        ['/user-management/create', () => cy.url().should('include', `${logIn}`)],
        ['/user-management/show/1', () => cy.url().should('include', `${logIn}`)],
        ['/user-management/edit/1', () => cy.url().should('include', `${logIn}`)],
        ['/product-management/list', () => cy.url().should('include', `${logIn}`)],
        ['/product-management/create', () => cy.url().should('include', `${logIn}`)],
        ['/product-management/show/1', () => cy.url().should('include', `/product-management/show/1`)],
        ['/product-management/edit/1', () => cy.url().should('include', `${logIn}`)],
        ['/category-management/list', () => cy.url().should('include', `${logIn}`)],

    ];

    const deleteRequests = [
        ['user', 'guest-user-tries-to-delete-a-user', (alias) => {
            cy.get(`@${alias}`).then((resp) => {

                expect(resp.status).to.eq(405);
                expect(resp.statusText).to.have.string('Method Not Allowed')
            });}
        ],

        ['product', 'guest-user-tries-to-delete-a-product', (alias) => {
            cy.get(`@${alias}`).then((resp) => {

                expect(resp.status).to.eq(405);
                expect(resp.statusText).to.have.string('Method Not Allowed')
            });}
        ],

        ['category', 'guest-user-tries-to-delete-a-category', (alias) => {
            cy.get(`@${alias}`).then((resp) => {

                expect(resp.status).to.eq(405);
                expect(resp.statusText).to.have.string('Method Not Allowed')
            });}
        ]
    ]

    routes.forEach((type) => {
        const [url, returnRoute] = type;

        it(`visits ${url}`, () => {

            cy.visit(`${url}`);

            returnRoute();
        })
    })





    deleteRequests.forEach((requestType) => {

        const [type, alias, method] = requestType;

        it(`tries to delete a(n) ${type}`, () => {

            cy.request({
                method: 'GET',
                url: `/${type}-management/delete/1`,
                failOnStatusCode: false
            }).as(`${alias}`);

            method(alias);

        })

    })

    it('buys product', () => {

        cy.visit('/storefront');


        cy.get(':nth-child(1) > .card > .card-body > .mb-2 > .text-muted > .fw-bold').then((element) => {
            let stockValue = parseInt(element.text());

            expect(stockValue).to.be.greaterThan(0);
        })

        cy.get(':nth-child(1) > .card > .card-body > :nth-child(4) > .btn-info').click();

        cy.get('.badge').should('be.visible');

        cy.get('.nav-item.m-auto > .nav-link').click();


        cy.wait(2000);

        cy.get('.dropdown-menu > :nth-child(2) > .btn').click();

        cy.url().should('include', 'shopping-basket/view-list');

        cy.get('.btn-info').click();

        cy.get('#firstName').type(orderForm.firstName);

        cy.get('#lastName').type(orderForm.lastName);

        cy.get('#email').type(orderForm.email);

        cy.get('#phone').type(orderForm.phone);

        cy.get('#address').type(orderForm.address);

        cy.get('#country').select(orderForm.countryIso2Code).should('have.value', orderForm.countryIso2Code);

        cy.wait(3000);

        cy.get('#state').should('be.enabled');

        cy.get('#state').select(orderForm.stateIso2Code).should('have.value', orderForm.stateIso2Code);

        cy.get('#zip').type(orderForm.postalCode);

        cy.wait(2000);

        cy.get('.mb-3 > .row > :nth-child(2) > .btn').click();

        cy.url().should('include', 'storefront');

        cy.get('.toast-body').should('be.visible');

        cy.get('.toast-body').should('have.text', 'Order taken, but its status is unpaid!');

    })
})
