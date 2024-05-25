import React, { useEffect, useRef } from "react";
import axios from "axios";
import { useState } from "react";
import { Link } from "react-router-dom";
import "../dashboard.css";
import Loading from "../../Loading";
import { baseU } from "../../confing";
import { useSelector } from "react-redux";
import { ToastContainer, toast } from "react-toastify";
const Requests = () => {
  const [loading, setLoading] = useState(false);
  const [update, setUpdate] = useState(false);

  const [inputs, setInputs] = useState({ status: "1" });
  const deleteMessage = () => toast.success("request deleted successfully");
  const updateMessage = () => toast.success("request updated successfully");
  const list = useRef();
  const [requests, setRequests] = useState([
    [{ items: "", price: "", status: "" }],
  ]);
  function handleInputs(e) {
    setInputs({ ...inputs, [e.target.name]: e.target.value });
  }
  const token = useSelector((state) => state.user?.user?.token);
  const baseUrl = baseU();
  useEffect(() => {
    setLoading(true);
    const res = axios

      .get(`${baseUrl}process/requestsShow.php`, {
        headers: {
          Accept: "application/json",
          Authorization: token,
        },
      })

      .then((res) => {
        setLoading(false);
        setRequests([res.data]);
      })

      .catch((e) => {
        console.log(e);
        setLoading(false);
      });
  }, [update]);
  const formdata = new FormData();
  async function deleteRequest(id) {
    try {
      setLoading(true);
      const res = await axios.post(
        `${baseUrl}delete/request.php?id=${id}`,
        null,
        {
          headers: {
            Authorization: token,
          },
        }
      );
      setLoading(false);
      deleteMessage();
      setUpdate(!update);
    } catch (e) {
      console.log(e);
    }
  }
  async function handleStatus(id, status) {
    formdata.append("status", status);

    try {
      const res = await axios.post(
        `${baseUrl}update/requestStatus.php?id=${id}`,
        formdata,
        {
          headers: {
            Authorization: token,
          },
        }
      );
      updateMessage();
      setUpdate(!update);
    } catch (e) {
      console.log(e);
    }
  }
  const requestsShow = requests[0].map((req, index) => {
    return (
      <div
        key={index}
        className="w-full flex  flex-wrap justify-between items-center request"
      >
        <div className=" felx flex-col items-start justify-between">
          <h1 className="font-bold text-[20px] items text-orange-600">
            {req.items}
          </h1>
          <h1 className="font-bold text-[20px] text-white"> {req.user_name}</h1>
          <p className="text-gray-300">{req.address}</p>
          <p className="text-gray-400">{req.phone}</p>
        </div>
        <div>
          <h1 className="font-bold mx-3 mobile:!text-[17px] text-[20px] bg-white text-orange-600 px-2 rounded-xl">
            {req.price}$
          </h1>
        </div>
        <div className="flex mt-3  w-full justify-between mobile:justify-between mobile:w-full  items-center">
          <i
            onClick={() => deleteRequest(req.id)}
            className="fa solid fa-trash mx-2 tab:!text-[17px]"
          ></i>
          <select
            className="bg-slate-600 mobile:p-2  mobile:mt-2 text-orange-500 p-3"
            name="status"
            id="status"
            onChange={(e) => handleStatus(req.id, e.target.value)}
          >
            <option value={req.status} disabled selected="selected">
              {req.status == "1"
                ? "Food Processing"
                : req.status == "2"
                ? "Out For Delivery"
                : "Delivered"}
            </option>
            <option value="1">Food Processing</option>
            <option value="2">Out For Delivery </option>
            <option value="3">Delivered</option>
          </select>
        </div>{" "}
        <ToastContainer />
      </div>
    );
  });
  return (
    <div className="w-full flex flex-col pb-[100px]   justify-start items-center ">
      {loading ? <Loading /> : requestsShow}
    </div>
  );
};

export default Requests;
