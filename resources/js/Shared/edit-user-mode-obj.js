import editProfileModeObj from "*js-shared/edit-profile-mode-obj"

const asArray = Object.entries(editProfileModeObj);
const filtered = asArray.filter(
    ([key, value]) => !key.toLowerCase().includes('address') && !key.toLowerCase().includes('phone')
);

export default {
    ...Object.fromEntries(filtered)
}

// export default {
//     changeProfilePictureButtonVisible: false,
//     editNameFormVisible: false,
//     editEmailFormVisible: false,
//     resetPasswordButtonVisible: false
// }
