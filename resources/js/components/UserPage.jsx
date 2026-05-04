import React, { useState } from "react";

export default function UserPage() {
  const [formData, setFormData] = useState({
    workExperience: "",
    kegiatan: "",
    sertifikat: "",
    organisasi: ""
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  return (
    <div>
      <h2>User Page</h2>
      <input
        type="text"
        name="workExperience"
        value={formData.workExperience}
        onChange={handleChange}
        placeholder="Work Experience"
      />
      <input
        type="text"
        name="kegiatan"
        value={formData.kegiatan}
        onChange={handleChange}
        placeholder="Kegiatan"
      />
      <input
        type="text"
        name="sertifikat"
        value={formData.sertifikat}
        onChange={handleChange}
        placeholder="Sertifikat"
      />
      <input
        type="text"
        name="organisasi"
        value={formData.organisasi}
        onChange={handleChange}
        placeholder="Organisasi"
      />
    </div>
  );
}