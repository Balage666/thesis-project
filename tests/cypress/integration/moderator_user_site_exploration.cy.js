describe('Moderator user explores the site', () => {

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



    const moderatorCredentials = {
        name: 'Just Moderator',
        email: 'just.moderator@bluevenue.tp',
        password: 'moderator'
    }


    const storefront = '/storefront';

    const routes = [
        ['/storefront', () => successfullyRedirectsTo(storefront)],
        ['/auth/log-in', () => successfullyRedirectsTo(storefront)],
        ['/auth/sign-up', () => successfullyRedirectsTo(storefront)],
        ['/dashboard/main', () => successfullyRedirectsTo('/dashboard/main')],
        ['/dashboard/charts', () => triggerHTTPresponse('/dashboard/charts')],
        ['/user-management/list', () => successfullyRedirectsTo('/user-management/list')],
        ['/user-management/create', () => successfullyRedirectsTo('/user-management/create')],
        ['/user-management/show/1', () => successfullyRedirectsTo('/user-management/show/1')],
        ['/user-management/edit/1', () => successfullyRedirectsTo('/user-management/edit/1')],
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
        cy.login({ name: moderatorCredentials.name })
    })


    routes.forEach((element) => {

        const [url, fireTest] = element;
        it(`tries to access ${url} page`, () => {

            fireTest();

        })

    })

    it('updates other user\'s details', () => {

        successfullyRedirectsTo('/users/profile/2');

        cy.get('.col-sm-12 > [type="button"]').should('be.visible');

        cy.get('[data-cy="toggle-edit-mode"]').should('be.visible');

        cy.get('[data-cy="toggle-edit-mode"]').click();

        cy.get('#name').should('be.visible');

        cy.get('#email').should('be.visible');

        cy.get('.col-sm-6.text-center > .text-secondary').should('be.visible');

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

    })

    it('explores a user\'s product page', () => {

        successfullyRedirectsTo('/users/profile/2');

        cy.get('#collapseCreatedProducts > .accordion-body').should('not.contain.text', 'Such emptiness!');

        cy.get(':nth-child(1) > .col-xl-10 > .card > .card-body > .row > .border-sm-start-none > .flex-column > .btn-secondary').click();

        cy.get('.col-lg-7 > :nth-child(3) > .d-flex > :nth-child(2) > .btn').click();

        cy.get('.toast-body').should('have.text', 'Rating deleted!');

        cy.get('.gap-3 > :nth-child(2) > .btn').click();

        cy.get('.toast-body').should('have.text', 'Added to Favorites!');

        cy.get('.gap-3 > :nth-child(1) > .btn').click();

        cy.get('.toast-body').should('have.text', 'Product added to basket!');

        cy.get('#commentInput').type('Cypress test comment');

        cy.get('.text-end > .btn').click();

        cy.get('.toast-body').should('have.text', 'Comment Added');
    })
})
