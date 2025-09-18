import { reactive } from "vue";

export const store = reactive({
  isLoggedIn: false,
  CurrentUser: null,
  
  // Role helpers
  get isAdmin() {
    return this.CurrentUser?.user_role === 'admin';
  },
  
  get hasAdminPrivileges() {
    return this.CurrentUser && ['admin', 'librarian'].includes(this.CurrentUser.user_role);
  },
  
  get userRole() {
    return this.CurrentUser?.user_role || 'user';
  },
  
  get isPartner() {
    return this.CurrentUser?.user_role === 'partner';
  }
});
