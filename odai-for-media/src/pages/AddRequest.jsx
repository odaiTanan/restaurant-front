import { useRef } from "react";
import { useSelector } from "react-redux";
export default function AddRequest() {
  const cart = useSelector((state) => state.cart);
  let inputs = useRef({
    country: "",
    street: "",
    buildingId: "",
    phone: "",
    items: cart,
  });

  function handleInputs(e) {
    inputs.current = { ...inputs.current, [e.target.name]: e.target.value };
    console.log(inputs.current);
  }

  return (
    <div className="addrequestcon py-12 gap-5 w-full flex flex-col items-center">
      <div className="inp">
        <input
          className="input "
          type="text"
          name="country"
          id="country"
          onChange={handleInputs}
          required
        />
        <span className="title">country</span>
      </div>
      <div className="inp">
        <input
          className="input "
          type="text"
          name="street"
          id="street"
          onChange={handleInputs}
          required
        />{" "}
        <span className="title">street</span>
      </div>
      <div className="inp">
        <input
          className="input "
          type="text"
          name="buildingId"
          id="buildingId"
          onChange={handleInputs}
          required
        />{" "}
        <span className="title">building</span>
      </div>
      <div className="inp">
        <input
          className="input "
          type="text"
          name="phone"
          id="phone"
          onChange={handleInputs}
          required
        />{" "}
        <span className="title">phone</span>
      </div>
    </div>
  );
}
