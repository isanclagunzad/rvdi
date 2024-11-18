import React, { RefObject, useEffect, useMemo, useRef, useState } from "react";
import { AutoCompleteWrapper, FloatingLabel } from "./styled";
import { AutoCompleteFieldProps, AutoCompleteOption } from "./type";
import { AutoComplete, Form } from "antd";
import { SearchOutlined } from "@ant-design/icons";
import pluralize from "pluralize";

function AutoCompleteField({
  options,
  label,
  name,
  onSearch,
  value,
  onSelect,
}: AutoCompleteFieldProps) {
  const [inputValue, setInputValue] = useState<string>("");
  const [inputDisplay, setInputDisplay] = useState<string>("");
  const [searchKey, setSearchKey] = useState("");
  const flotingLabel = useMemo(() => pluralize.singular(label), [label]);

  const filteredOptions = useMemo<any[]>(() => {
    return options.filter((option) => {
      return String(option.label).toLowerCase().match(searchKey.toLowerCase());
    });
  }, [options, searchKey]);

  const handleInputChange = (value: string, option: any) => {
    setInputValue(value as any);

    if (!option.label) {
      setInputDisplay(value);
    } else {
      setInputDisplay(option.label);
    }
  };

  useEffect(() => {
    onSearch && onSearch(inputDisplay, pluralize.singular(String(name || "")));
  }, [inputDisplay]);

  const handleKeyPress = (event: React.KeyboardEvent<HTMLInputElement>) => {
    if (
      event.key === "Enter" &&
      filteredOptions.length > 0 &&
      !filteredOptions
    ) {
      setInputValue(filteredOptions[0]);
    }
  };

  const handleSearch = (value: string) => {
    setSearchKey(value);
  };

  useEffect(() => {
    setInputValue(value);
    setInputDisplay(value);
  }, [value]);

  return (
    <AutoCompleteWrapper>
      <AutoComplete
        value={inputDisplay}
        onChange={handleInputChange}
        onSearch={handleSearch}
        options={filteredOptions}
        placeholder={""}
        onKeyDown={handleKeyPress}
        onSelect={onSelect}
      />
      <FloatingLabel hasValue={!!inputValue}>
        {!inputValue && <SearchOutlined />}&nbsp;
        {flotingLabel}
      </FloatingLabel>
    </AutoCompleteWrapper>
  );
}

export default AutoCompleteField;
