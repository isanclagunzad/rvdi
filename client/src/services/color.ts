import { PresetColors } from "antd/es/theme/interface/presetColors";
import FlatColors from "flat-colors";
import toHex from "colornames";

/**
 * Skip red because it's reserved for warning signs
 * @param index
 */
export const getColorByIndex = (index: number) => {
  let color,
    random = 1,
    colorIndex = index,
    skipColors = ["red", "magenta", "pink", "geekblue"];

  do {
    color = PresetColors[(colorIndex += random)];
    random = Math.round(Math.random() * 5);
  } while (skipColors.indexOf(color) > -1);

  return FlatColors(toHex(color))[3];
};
