import { userRoles } from "*js-shared/user-roles";

export const filterUserRoles = userRoles.filter(role => role !== 'Customer');
