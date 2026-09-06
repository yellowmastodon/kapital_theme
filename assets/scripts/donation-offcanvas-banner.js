const DONATION_OFFCANVAS_HIDDEN_COOKIE = "darujme_banner_hidden";
import Offcanvas from "bootstrap/js/dist/offcanvas";

function darujmeOffcanvas() {
  if (site_info.complianz_active === "1") {
    document.addEventListener("cmplz_track_status", handleComplianzTrackStatus);
    document.addEventListener(
      "cmplz_banner_status",
      handleComplianzBannerStatus,
    );
  } else {
    showOrRemoveOffcanvasBanner();
  }
}

/** shows banner wehen cookie banner dismissed */
const handleComplianzBannerStatus = (data) => {
  if (data.detail !== "show") {
    showOrRemoveOffcanvasBanner();
  }
};

/** shows banner if do not track, which should bypass cmplz_banner_status */
const handleComplianzTrackStatus = (status) => {
  if (status.detail === "do_not_track") {
    showOrRemoveOffcanvasBanner();
  }
};

/** to be sure that it does not fire more than once */
function removeAllShowListeners() {
  document.removeEventListener(
    "cmplz_track_status",
    handleComplianzTrackStatus,
  );
  document.removeEventListener(
    "cmplz_banner_status",
    handleComplianzBannerStatus,
  );
}

function setOffcanvasBannerCookie(days = 3) {
  document.cookie = `${DONATION_OFFCANVAS_HIDDEN_COOKIE}=true; max-age=${
    days * 24 * 60 * 60
  }; path=/`;
}

/** shows offcanvas banner or removes it
 *
 */
function showOrRemoveOffcanvasBanner() {
  removeAllShowListeners();

  const offcanvasEl = document.getElementById("darujme-offcanvas-banner");
  if (!offcanvasEl) return;

  if (document.cookie.includes(`${DONATION_OFFCANVAS_HIDDEN_COOKIE}=true`)) {
    offcanvasEl.remove();
    return;
  }

  const versions = offcanvasEl.querySelectorAll(".darujme-offcanvas__version");

  let versionNum = 0;

  if (versions.length > 1) {
    versionNum = Math.floor(Math.random() * versions.length);
  }

  versions.forEach((el) => {
    el.classList.add("d-none");
  });

  versions[versionNum].classList.remove("d-none");

  versions[versionNum]
    .querySelectorAll('button[data-bs-dismiss="offcanvas"]')
    .forEach((btn) => {
      btn.addEventListener("click", () => {
        const days = Number(btn.dataset.darujmeD);
        setOffcanvasBannerCookie(days);
      });
    });

  //only remove d-none, so no transition
  if (offcanvasEl.classList.contains("darujme-offcanvas--fullscreen")) {
    // native Bootstrap show — handles its own transition timing,
    // backdrop, focus trap, and aria state
    setTimeout(() => {
      Offcanvas.getOrCreateInstance(offcanvasEl).show();
    }, 300);
  } else {
    //only remove d-none, so no transition
    offcanvasEl.classList.remove("d-none");
    offcanvasEl.focus();
  }
}

export { darujmeOffcanvas, setOffcanvasBannerCookie };
