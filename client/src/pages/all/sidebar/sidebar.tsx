import { accessWindowVar } from "src/services/parseVar";
import { Layout, Menu, Slider } from "antd";
import { useEffect, useRef, useState } from "react";
import Icon, {
  DashboardOutlined,
  UploadOutlined,
  UserOutlined,
  VideoCameraOutlined,
} from "@ant-design/icons";

import { Navigation } from "react-minimal-side-navigation";
import "react-minimal-side-navigation/lib/ReactMinimalSideNavigation.css";
import { getAsPath, MenuItem, SideBarMenu } from "src/pages/all/sidebar/type";
import { getMenuIcon, SidebarStyled } from "src/pages/all/sidebar/style";
import { NavItemProps } from "react-minimal-side-navigation/lib/side-nav";

function Sidebar() {
  const [items, setItems] = useState<NavItemProps[]>([]);
  const routes = useRef<{ [key: string]: string }>({});

  const addRoute = (key: string, value: string) => {
    if (value) {
      routes.current[key] = getAsPath(value);
    }
  };

  const getSubMenus = (sideBarMenu: SideBarMenu, parentName: string = "") => {
    let subMenus: any = [];

    const push = (sideBarMenu: SideBarMenu) => {
      Object.entries(sideBarMenu).forEach((menu) => {
        const parentMenu = menu[1];

        const subMenuList = Object.values(
          menu[1]?.sub_menu || {},
        ) as MenuItem[];

        if (subMenuList.length) {
          for (let subMenuItem of subMenuList) {
            subMenus.push({
              ...subMenuItem,
              itemId: [parentName, subMenuItem.name].join(" / "),
            });
          }
        } else {
          subMenus.push({
            ...parentMenu,
          });
        }
      });
    };

    push(sideBarMenu);

    return getMenus(subMenus as SideBarMenu, parentName);
  };

  const getMenus = (
    sideBarMenu: SideBarMenu,
    parentName: string = "",
  ): NavItemProps[] => {
    return Object.entries(sideBarMenu)
      .map((entry) => {
        const menu = entry[1];
        const itemId = [parentName, menu?.name].join("/");
        addRoute(itemId, menu.route);
        return {
          title: menu?.name,
          itemId,
          elemBefore: () => getMenuIcon(menu?.name),
          subNav: getSubMenus(menu?.sub_menu || {}, menu?.name),
          hasRoute: parentName === "" || (parentName && !!menu.route),
        };
      })
      .filter((item) => item.hasRoute);
  };

  useEffect(() => {
    const sideBarMenu = accessWindowVar("sideBarMenu") as SideBarMenu;

    setItems(
      getMenus([
        { name: "Dashboard", route: "/dashboard" },
        ...Object.values(sideBarMenu),
      ] as SideBarMenu),
    );
  }, []);

  const handleNavSelect = ({ itemId }: { itemId: string }) => {
    const href = routes.current[itemId];
    if (href) {
      window.location.href = href;
    }
  };

  const [activeItemId, setActiveItemId] = useState("/Dashboard");

  useEffect(() => {
    const pathName = getAsPath(window.location.href);
    const paths = Object.values(routes.current);
    const pathIndex = paths.indexOf(pathName);
    let activeItemId = sessionStorage.getItem("activeItemId") as string;

    if (paths.length && paths.indexOf(pathName) > -1) {
      activeItemId = Object.keys(routes.current)[pathIndex];
      sessionStorage.setItem("activeItemId", activeItemId);
    }
    setActiveItemId(activeItemId);
  }, [routes.current]);

  return (
    <SidebarStyled>
      <Navigation
        // you can use your own router's api to get pathname
        activeItemId={activeItemId}
        onSelect={handleNavSelect}
        items={items}
      />
    </SidebarStyled>
  );
}

export default Sidebar;
