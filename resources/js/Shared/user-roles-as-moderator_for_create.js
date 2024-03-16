import { userRoles } from "*js-shared/user-roles";

export const userRolesAsModeratorForCreate = userRoles.filter(role => role !== 'Admin').filter(role => role !== 'Moderator');
