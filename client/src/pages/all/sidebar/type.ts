export interface MenuItem {
  name: string;
  sub_menu?: SideBarMenu;
}

export interface SideBarMenu {
  [key: number]: MenuItem;
}

export const getAsPath = (url: string) => {
  if (url.match("http")) {
    return "/" + url.split("/").slice(3).join("/");
  }
  return url;
};
