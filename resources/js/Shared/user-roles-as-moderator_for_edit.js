import { filterUserRoles } from "*js-shared/filtered-user-roles";

export const userRolesAsModeratorForEdit = filterUserRoles.filter((role) => role != 'Admin' && role != 'Moderator');
