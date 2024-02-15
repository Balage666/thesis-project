import { userRoles } from "./user-roles";

export const filterUserRoles = userRoles.filter(role => role !== 'Customer');
